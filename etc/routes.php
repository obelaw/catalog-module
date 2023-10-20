<?php

use Illuminate\Support\Facades\Route;
use Obelaw\Catalog\Http\Controllers\HomeController;
use Obelaw\Catalog\Livewire\Categories\CatagoryCreateComponent;
use Obelaw\Catalog\Livewire\Categories\CatagoryUpdateComponent;
use Obelaw\Catalog\Livewire\Categories\CategoriesIndexComponent;
use Obelaw\Catalog\Livewire\Products\ProductCreateComponent;
use Obelaw\Catalog\Livewire\Products\ProductsIndexComponent;
use Obelaw\Catalog\Livewire\Products\ProductUpdateComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::prefix('catalog')->group(function () {
    Route::get('/', HomeController::class)->name('obelaw.catalog.home');

    // Categories
    Route::prefix('categories')->group(function () {
        Route::get('/', CategoriesIndexComponent::class)->name('obelaw.catalog.categories.list');
        Route::get('/create', CatagoryCreateComponent::class)->name('obelaw.catalog.categories.create');
        Route::get('/{catagory}/update/', CatagoryUpdateComponent::class)->name('obelaw.catalog.categories.update');
    });

    // Products
    Route::prefix('products')->group(function () {
        Route::get('/', ProductsIndexComponent::class)->name('obelaw.catalog.products.list');
        Route::get('/create', ProductCreateComponent::class)->name('obelaw.catalog.products.create');
        Route::get('/{product}/update/', ProductUpdateComponent::class)->name('obelaw.catalog.products.update');
    });
});
