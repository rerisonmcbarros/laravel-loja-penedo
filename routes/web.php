<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SaleController;
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

Route::controller(CartController::class)->group(function () {
    Route::get('cart', 'index')->name('cart.index');
    Route::post('cart', 'addItem')->name('cart.addItem');
    Route::delete('cart/{item}', 'removeItem')->name('cart.removeItem');
});

Route::controller(SaleController::class)->group(function () {
    Route::get('vendas/por-periodo', 'getSalesByPeriod')->name('sales.period');
});

Route::resource('vendas', SaleController::class)->except([
    'edit',
    'update',
])->names([
    'index' => 'sales.index',
    'store' => 'sales.store',
    'show' => 'sales.show',
    'create' => 'sales.create',
    'destroy' => 'sales.destroy',
])->parameters([
    'vendas' => 'sale'
]);
