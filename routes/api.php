<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;

Route::post('/register',[UserController::class, 'register']);
Route::post('/login',   [UserController::class, 'authenticate']);
    
Route::group(['prefix' => 'products'], function () {
    Route::get('/',     [ProductController::class, 'listOfProduct'])->name('productList');
});

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/user',     [UserController::class, 'getAuthenticatedUser']); 
});



