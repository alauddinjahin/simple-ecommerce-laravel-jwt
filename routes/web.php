<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubcategoryController;

Route::redirect('/', '/dashboard');


Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');


    Route::group(['prefix' => 'categories'], function () {
        Route::get('/',                 [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/list',             [CategoryController::class, 'getCategoryListData'])->name('categories.list');
        Route::post('/create',          [CategoryController::class, 'createCategory'])->name('categories.create');
        Route::post('/update',          [CategoryController::class, 'updateCategory'])->name('categories.update');
    });


    Route::group(['prefix' => 'subcategories'], function () {
        Route::get('/',                 [SubcategoryController::class, 'index'])->name('subcategories.index');
        Route::get('/list',             [SubcategoryController::class, 'getSubcategoryListData'])->name('subcategories.list');
        Route::post('/create',          [SubcategoryController::class, 'createSubcategory'])->name('subcategories.create');
        Route::post('/update',          [SubcategoryController::class, 'updateSubcategory'])->name('subcategories.update');
    });


    Route::group(['prefix' => 'products'], function () {
        Route::get('/',                  [ProductController::class, 'index'])->name('products.index');
        Route::post('/create',           [ProductController::class, 'createProduct'])->name('products.create');
        Route::post('/update',           [ProductController::class, 'updateProduct'])->name('products.update');
    });

});


require __DIR__.'/auth.php';