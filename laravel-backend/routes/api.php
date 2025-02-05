<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('messages', [MessageController::class, 'index']);  // Get all messages
Route::post('messages', [MessageController::class, 'store']); // Create a new message
Route::delete('messages/{message}', [MessageController::class, 'destroy']); // Delete a specific message
