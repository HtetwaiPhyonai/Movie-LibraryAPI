<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\UserController;
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


  Route::post('/login', [UserController::class, 'login']);
  Route::post('/register', [UserController::class, 'register']);
  Route::get('/list', [MovieController::class, 'list']);
  Route::get('/show/{id}', [MovieController::class, 'show']);
  Route::post('/comment' , [CommentController::class , 'create']);
  Route::put('/comment-update/{id}' , [CommentController::class , 'update']);
  Route::delete('/comment-delete/{id}' , [CommentController::class , 'delete']);

//movie 

Route::middleware('auth:api')->group(function () {

  Route::post('/store', [MovieController::class, 'store']);
  Route::put('/update/{id}', [MovieController::class, 'update']);
  Route::delete('/delete/{id}', [MovieController::class, 'delete']);
});
