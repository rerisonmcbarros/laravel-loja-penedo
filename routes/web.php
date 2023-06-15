<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseSessionController;

Route::get('/', function () {
     
});

//Rotas de Recursos de Categorias
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

//Rotas de Recursos de Produtos
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

//Rotas de Recursos de Vendas
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

//Rotas de Recursos de Compras/Aquisições
Route::controller(PurchaseSessionController::class)->group(function () {
    Route::get('compras/registrar', 'create')->name('purchases.create');
    Route::post('compras/adicionar-item', 'addItem')->name('purchases.addItem');
    Route::delete('compras/remover-item/{item}', 'removeItem')->name('purchases.removeItem');
});

Route::get('compras/por-periodo', [PurchaseController::class, 'getPurchasesByPeriod'])->name('purchases.period');

Route::resource('compras',PurchaseController::class)->except([
    'create',
    'edit',
    'update'
])->names([
    'index' => 'purchases.index',
    'store' => 'purchases.store',
    'show' => 'purchases.show',
    'destroy' => 'purchases.destroy'
])->parameters([
    'compras' => 'purchase'
]);
