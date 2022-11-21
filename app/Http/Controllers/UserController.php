<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserReadDeleteRequest;

class UserController extends Controller
{
    // Login user
    public function login(LoginRequest $request){
        
        /* Getting the validated data from the request. */
        $validated = $request->safe()->all();

        /* Getting the first admin with the username from the request. */
        $data = User::where('username', $validated['username'])->first();

        /* Checking if the user exists, if the password is correct or if the type is not admin*/
        if (!$data || !Hash::check($validated['password'], $data->password)) {
               
            /* Returning a 401 status code with a message. */
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);  

        }      

        /* Deleting all the tokens for the user. */
        $data->tokens()->delete();

        /* Creating a token for the user. */
        $token = $data->createToken('auth_user')->plainTextToken;
        
        /* Returning the token to the user. */
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = User::all();

        return $request;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LoginRequest $request)
    {
        $validated = $request->safe()->all();

        $validated['password'] = Hash::make($validated['password']);
        
        $data = User::create($validated);

        return response()->json([
            'username' => $data->username,
            'message'    => 'User created successfully!',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserReadDeleteRequest $request)
    {
        $validated = $request->safe()->all();
        $data = User::findOrFail($validated['id']);        
        return response()->json([
            'data' => $data,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        $validated = $request->safe()->all();
        $data = User::findOrFail($validated['id']);

        $validated['password'] = Hash::make($validated['password']);
        
        $data->update($validated);

        return response()->json([
            'data' => $data,
            'message'    => 'User updated successfully!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserReadDeleteRequest $request)
    {
        $validated = $request->safe()->all();
        $data = User::findOrFail($validated['id']);        
        $data->delete($validated);

        return response()->json([
            'message' => 'User deleted successfully!',
        ]);
    }
}
