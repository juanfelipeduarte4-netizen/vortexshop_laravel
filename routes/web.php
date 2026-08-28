<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\NosotrosController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\NosotrosAdminController;
use App\Http\Controllers\Admin\SoportController as AdminSoportController;
use App\Http\Controllers\Admin\PromocionController;

// ---------- PÚBLICAS ----------
Route::view('/', 'index')->name('inicio');
Route::get('/nosotros', [NosotrosController::class, 'index'])->name('nosotros.index');

Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/producto/{producto}', [CatalogoController::class, 'show'])->name('catalogo.show');

// ---------- SOPORTE CLIENTE ----------
Route::get('/soporte', [SoporteController::class, 'create'])->name('soporte.create');
Route::middleware(['auth'])->group(function () {
    Route::post('/soporte', [SoporteController::class, 'store'])->name('soporte.store');
});

// ---------- AUTENTICACIÓN ----------
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ---------- CARRITO ----------
Route::prefix('carrito')->name('carrito.')->group(function () {
    Route::get('/', [CarritoController::class, 'index'])->name('index');
    Route::post('/agregar/{id}', [CarritoController::class, 'agregar'])->name('agregar');
    Route::post('/actualizar/{id}', [CarritoController::class, 'actualizar'])->name('actualizar');
    Route::post('/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('eliminar');
    Route::post('/vaciar', [CarritoController::class, 'vaciar'])->name('vaciar');
});

// ---------- ADMINISTRACIÓN ----------
Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    Route::get('/productos', [AdminProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear', [AdminProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [AdminProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/editar', [AdminProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [AdminProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [AdminProductoController::class, 'destroy'])->name('productos.destroy');
    Route::patch('/productos/{id}/reactivar', [AdminProductoController::class, 'reactivar'])->name('productos.reactivar');

    Route::get('/nosotros', [NosotrosAdminController::class, 'show'])->name('nosotros');
    Route::put('/nosotros', [NosotrosAdminController::class, 'update'])->name('nosotros.update');
   Route::resource('promociones', PromocionController::class)
    ->except(['show'])
    ->parameters(['promociones' => 'promocion']);
    // SOPORTE / BUZÓN ADMIN
    Route::get('/soporte', [AdminSoportController::class, 'index'])->name('soporte.index');
    Route::post('/soporte/{soporte}/responder', [AdminSoportController::class, 'responder'])->name('soporte.responder');
    Route::post('/soporte/{soporte}/en-revision', [AdminSoportController::class, 'marcarEnRevision'])->name('soporte.enRevision');
});