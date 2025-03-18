<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/posts');

Route::middleware('auth:sanctum')->prefix('v1')->group(function(){

    Route::get('/users', function(){
        return response()->json([
            'users'=>User::all()
        ]);
    });
});