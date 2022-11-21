<?php

use App\Http\Controllers\StreamController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/auth/user/login', [UserController::class, 'login']);

Route::group(['prefix' => 'user', 'middleware'=>['auth:sanctum']], function(){
    Route::get('list', [UserController::class, 'list']);
    Route::get('read', [UserController::class, 'read']);
    Route::post('create', [UserController::class, 'create']);
    Route::post('update', [UserController::class, 'update']);
    Route::post('update-permission', [UserController::class, 'updatePermission']);
    Route::delete('delete', [UserController::class, 'delete']);

    Route::group(['prefix' => 'stream'], function() {
        Route::get('list' , [StreamController::class, 'list']);
        Route::post('create' , [StreamController::class, 'create']);
        Route::get('read', [StreamController::class, 'read']);
        Route::post('create', [StreamController::class, 'create']);
        Route::post('update', [StreamController::class, 'update']);
        Route::delete('delete', [StreamController::class, 'delete']);
        Route::get('generate', [StreamController::class, 'generate']);
    });
    
});


