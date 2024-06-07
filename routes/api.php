<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users',[CustomAuthController::class, 'index']);
Route::post('/users',[CustomAuthController::class, 'upload']);
Route::put('/users/edit/{id}', [CustomAuthController::class, 'edit']);
Route::delete('/users/edit/{id}', [CustomAuthController::class, 'delete']);

    

