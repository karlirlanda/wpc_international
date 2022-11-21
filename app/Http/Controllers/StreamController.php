<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use Illuminate\Http\Request;
use App\Http\Requests\StreamRequest;
use App\Http\Requests\StreamUpdateRequest;
use App\Http\Requests\StreamReadDeleteRequest;

class StreamController extends Controller
{
    public function generate(Request $request)
    {
        $status = 0;
        $data = null;

        $permission = auth()->user()->permission;
        if($permission == 1)
        {
            $stream = Stream::whereId($request->id)->whereStatus(1)->first();
            if($stream) {
                $length = strlen($stream->url);
                $epoch = strtotime('+ '. $stream->exp_number . ' ' .$stream->exp_unit, time());
                $raw_hash = $stream->hash . $stream->url . '?p=' . $length . '&e=' . $epoch;
                $hash = md5($raw_hash);
                $data = $stream->url . 'manifest.m3u8' . '?p=' . $length . '&e=' . $epoch .'&h=' . $hash;
            }
            $status = 1;
        
        }else {
            $status = 2;
        }
        return response()->json([
            'status' => $status,
            'url' => $data

        ]);
        
    }

    public function list()
    {

        $status = 0;
        
        $permission = auth()->user()->permission;
    
        if($permission == 1)
        {
            $data = Stream::all();
            
            $status = 1;

        }else{

            $data = null;

            $status = 2;
        }

        return response()->json([
            'data' => $data,
            'status' => $status
            ]);
        
    }

    public function create(StreamRequest $request)
    {
        $validated = $request->safe()->all();
        $data = Stream::create($validated);

        return response()->json([
            'name' => $data->name,
            'message'    => 'Stream created successfully!',
        ]);
    }

    public function read(StreamReadDeleteRequest $request)
    {
        
        $validated = $request->safe()->all();
        $data = Stream::findOrFail($validated['id']);        
        return response()->json([
            'data' => $data,
            'url'
        ]);

    }

    public function update(StreamUpdateRequest $request)
    {
        $validated = $request->safe()->all();
        $data = Stream::findOrFail($validated['id']);
        
        $data->update($validated);

        return response()->json([
            'data' => $data,
            'message'    => 'Stream updated successfully!',
        ]);
    }

    public function delete(StreamReadDeleteRequest $request)
    {
        $validated = $request->safe()->all();
        $data = Stream::findOrFail($validated['id']);        
        $data->delete($validated);

        return response()->json([
            'message' => 'Stream deleted successfully!',
        ]);
    }
}
