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
    Route::get('list', [UserController::class, 'index']);
    Route::get('read', [UserController::class, 'show']);
    Route::post('create', [UserController::class, 'create']);
    Route::post('update', [UserController::class, 'update']);
    Route::delete('delete', [UserController::class, 'destroy']);

    Route::group(['prefix' => 'stream'], function() {
        Route::get('list' , [StreamController::class, 'index']);
        Route::post('create' , [StreamController::class, 'create']);
        Route::get('read', [StreamController::class, 'show']);
        Route::post('create', [StreamController::class, 'create']);
        Route::post('update', [StreamController::class, 'update']);
        Route::delete('delete', [StreamController::class, 'destroy']);
        Route::get('generate', [StreamController::class, 'generate']);
    });
    
});


