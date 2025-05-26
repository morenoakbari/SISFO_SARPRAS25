<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// User routes
Route::get('/pengguna', [UserController::class, 'index'])->name('user.index')->middleware('auth');
Route::post('/users/store', [UserController::class, 'store'])->name('user.store')->middleware('auth');
Route::get('/users', [UserController::class, 'index'])->name('user.list')->middleware('auth');

// Kategori routes
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index'); // Semua role
Route::get('/kategori/{kategori}', [KategoriController::class, 'show'])->name('kategori.show');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store')->middleware('admin');
Route::put('kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::resource('kategori', KategoriController::class)->middleware('auth');

// Barang routes
Route::resource('barang', BarangController::class);

// Peminjaman routes
Route::get('/dashboard/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::post('/dashboard/peminjaman/{peminjaman}/update-status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::post('/peminjaman/{peminjaman}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
Route::get('/peminjaman/form', [PeminjamanController::class, 'form'])->name('peminjaman.form');
Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');

// Route untuk Pengembalian
Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index')->middleware('auth');
Route::post('/pengembalian/{id}', [PengembalianController::class, 'updateStatus'])->name('pengembalian.updateStatus');

