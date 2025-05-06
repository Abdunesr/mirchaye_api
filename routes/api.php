<?php

use App\Http\Middleware\EnsureNebeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PostController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/parties', [PartyController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
  
    Route::post('/logout', [AuthController::class, 'logout']);
    
   
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    
   
    Route::middleware(EnsureNebeUser::class)->group(function () {
        Route::get('/pending-parties', [PartyController::class, 'pendingParties']);
        Route::post('/approve-party/{id}', [PartyController::class, 'approveParty']);
        Route::post('/reject-party/{id}', [PartyController::class, 'rejectParty']);
    });
});