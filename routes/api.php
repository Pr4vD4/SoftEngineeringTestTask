<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('forceJson')->group(function () {

    Route::group(['middleware' => ['guest:api']], function () {

        Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
        Route::post('/auth', [\App\Http\Controllers\AuthController::class, 'auth']);

    });

    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile']);

        Route::post('/notes', [\App\Http\Controllers\NoteController::class, 'store']);
        Route::get('/notes/display', [\App\Http\Controllers\NoteController::class, 'users_notes']);

    });

    Route::group(['middleware' => ['auth:api', 'admin']], function () {

        Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
        Route::apiResource('users', \App\Http\Controllers\UserController::class);

        Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index']);
        Route::get('/user/notes/{user}', [\App\Http\Controllers\NoteController::class, 'user_note']);

        Route::get('/test', function () {
            return response()->json([
                'message' => 'success'
            ]);
        });

    });

});

