<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/users', [UserController::class, 'allUsers']);
Route::get('/user/{username}', [UserController::class, 'user']);
Route::post('/user', [UserController::class, 'createUser']);
Route::put('/user/{username}', [UserController::class, 'updateUser']);
Route::delete('/user/{username}', [UserController::class, 'deleteUser']);
