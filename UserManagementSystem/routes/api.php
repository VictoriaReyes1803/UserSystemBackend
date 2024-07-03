<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => ''], function () {
    Route::any('403', function() {
        return response()->json([
            'data' => 'No auntentificado.'
        ], 403);
    })->name('notauthenticated');
    Route::post('/create', [UserController::class, 'create']); 
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::group(['middleware' => ['auth:api']], function () {
        //Route::post('verify-code', [AuthController::class, 'verificar']);
        Route::get('index',[UserController::class, 'index']);
        Route::get('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
        Route::put('update/{id}', [UserController::class, 'update']);
        Route::delete('delete/{id}', [UserController::class, 'destroy']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});