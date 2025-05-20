<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);

    // Rutas protegidas por roles
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware(CheckRole::class.':admin,vendedor')
        ->name('products.index');

    Route::get('/customers', [CustomerController::class, 'index'])
        ->middleware(CheckRole::class.':admin,cliente,vendedor')
        ->name('customers.index');

    Route::get('/categories', [CategoryController::class, 'index'])
        ->middleware(CheckRole::class.':admin')
        ->name('categories.index');

    Route::get('/invoices', [InvoiceController::class, 'index'])
        ->middleware(CheckRole::class.':admin')
        ->name('invoices.index');
});

require __DIR__.'/auth.php';
