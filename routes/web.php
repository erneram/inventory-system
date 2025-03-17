<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesDetailController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // RUTAS DE PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS DE CATEGORIAS
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{categoryId}', [CategoryController::class, 'update'])->name('categories.update');
    Route::put('/categories/{categoryId}', [CategoryController::class, 'delete'])->name('categories.delete');

    // RUTAS DE PRODUCTOS
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');


    // RUTA DE PRECIOS
    Route::get('/prices', [PriceController::class, 'index'])->name('prices.index');
    Route::post('/prices', [PriceController::class, 'store'])->name('prices.store');

    // RUTA DE VENTAS
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    // RUTA DE DETALLE DE VENTA
    Route::get('/sales-details', [SalesDetailController::class, 'index'])->name('sales-details.index');
    Route::post('/sales-details', [SalesDetailController::class, 'store'])->name('sales-details.store');

    // RUTA DE ALMACEN
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store');

    // RUTA DE MOVIMIENTOS DE INVENTARIO
    Route::get('/inventory-movements', [InventoryMovementController::class, 'index'])->name('inventory-movements.index');
    Route::post('/inventory-movements', [InventoryMovementController::class, 'store'])->name('inventory-movements.store');

    // RUTA DE USUARIOS
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

require __DIR__ . '/auth.php';
