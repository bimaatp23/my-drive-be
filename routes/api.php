<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users Service
Route::middleware(['check.token'])->group(function () {
    Route::get('/user/list', [UserController::class, 'allUsers']);
    Route::get('/user/{email}', [UserController::class, 'user']);
    Route::post('/user/update', [UserController::class, 'updateUser']);
});
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);

// Tokens Service
Route::post('/token/create', [TokenController::class, 'createToken']);
Route::post('/token/update', [TokenController::class, 'updateToken']);
Route::post('/token/check', [TokenController::class, 'checkToken']);