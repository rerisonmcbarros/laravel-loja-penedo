<?php

use Illuminate\Support\Facades\Route;
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
