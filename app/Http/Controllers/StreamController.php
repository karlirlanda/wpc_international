<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use Illuminate\Http\Request;
use App\Http\Requests\StreamRequest;
use App\Http\Requests\StreamUpdateRequest;
use App\Http\Requests\StreamReadDeleteRequest;

class StreamController extends Controller
{
    public function __construct()
    {
        $this->stream = new Stream;
    }
    public function generate(Request $request)
    {
        $stream = $this->stream->where([
                    ['id', $request->id],
                    ['status', 1]
                    ])->first();

            if($stream) {
                    $length = strlen($stream->url);
                    $epoch = strtotime('+ '. $stream->exp_number . ' ' .$stream->exp_unit, time());
                    $raw_hash = $stream->hash . $stream->url . '?p=' . $length . '&e=' . $epoch;
                    $hash = md5($raw_hash);
                    $url = $stream->url . 'manifest.m3u8' . '?p=' . $length . '&e=' . $epoch .'&h=' . $hash;
            
            return response()->json([
                'url' => $url,
                'status' => 1
            ]);
            }

        return response()->json([
        'status' => 0
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streams = Stream::all();
        return $streams;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $validated = $request->safe()->all();
        //Generate a url for a specific stream
        $data = Stream::create($request);

        return response()->json([
            'name' => $data->name,
            'message'    => 'Stream created successfully!',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
    public function show(StreamReadDeleteRequest $request)
    {
        $validated = $request->safe()->all();
        $data = Stream::findOrFail($validated['id']);        
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
    public function edit(Stream $stream)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stream  $stream
     * @return \Illuminate\Http\Response
     */
    public function destroy(StreamReadDeleteRequest $request)
    {
        $validated = $request->safe()->all();
        $data = Stream::findOrFail($validated['id']);        
        $data->delete($validated);

        return response()->json([
            'message' => 'Stream deleted successfully!',
        ]);
    }
}
