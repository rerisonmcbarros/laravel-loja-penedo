<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {

});

Route::resource('categorias', CategoryController::class)->except([
    'show'
])->names([
    'index' => 'categories.index',
    'store' => 'categories.store',
    'create' => 'categories.create',
    'update' => 'categories.update',
    'destroy' => 'categories.destroy',
    'edit' => 'categories.edit',
])->parameters([
    'categorias' => 'category'
]);

Route::resource('produtos', ProductController::class)->except([
    'show'
])->names([
    'index' => 'products.index',
    'store' => 'products.store',
    'create' => 'products.create',
    'update' => 'products.update',
    'destroy' => 'products.destroy',
    'edit' => 'products.edit',
])->parameters([
    'produtos' => 'product'
]);
