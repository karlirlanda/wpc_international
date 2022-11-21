<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserReadDeleteRequest;
use App\Http\Requests\UserUpdatePermissionRequest;

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

    public function index()
    {
        $request = User::all();

        return $request;
    }

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

    public function show(UserReadDeleteRequest $request)
    {
        $validated = $request->safe()->all();
        $data = User::findOrFail($validated['id']);        
        return response()->json([
            'data' => $data,
        ]);
    }

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

    public function destroy(UserReadDeleteRequest $request)
    {
        $validated = $request->safe()->all();
        $data = User::findOrFail($validated['id']);        
        $data->delete($validated);

        return response()->json([
            'message' => 'User deleted successfully!',
        ]);
    }

    public function updatePermission (UserUpdatePermissionRequest $request)
    {
        $validated = $request->safe()->all();
        $data = User::findOrFail($validated['id']);

        $data->update($validated);

        return response()->json([
            'data' => $data,
            'message'    => 'User permission updated successfully!',
        ]);
    }
}
