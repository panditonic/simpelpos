<?php

use App\Http\Controllers\DasborController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login',[LoginController::class, 'index']);
Route::get('dasbor',[DasborController::class, 'index'])->name('dasbor');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Authentication Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/check-auth', [LoginController::class, 'checkAuth'])->name('check.auth');
Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot.password');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
});

// Route to fetch categories and brands for select inputs
Route::get('/produks/categories-brands', [ProdukController::class, 'getCategoriesAndBrands'])->name('produks.getCategoriesAndBrands');

Route::get('/produks/datatable', [ProdukController::class, 'datatable'])->name('produks.datatable');
Route::post('/produks/{id}', [ProdukController::class, 'update'])->name('produks.update');
Route::resource('produks', ProdukController::class)->names([
    'index' => 'produks.index',
    'create' => 'produks.create',
    'store' => 'produks.store',
    'show' => 'produks.show',
    'edit' => 'produks.edit',
    // 'update' => 'produks.update', // bagian ini methode PUT tidak bekerja
    'destroy' => 'produks.destroy',
]);

Route::get('pelanggans/datatable', [PelangganController::class, 'datatable'])->name('pelanggans.datatable');
Route::resource('pelanggans', PelangganController::class);

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [DasborController::class, 'profile'])->name('profile');
    Route::put('/profile', [DasborController::class, 'updateProfile'])->name('profile.update');
    
    // Settings routes
    Route::get('/settings', [DasborController::class, 'settings'])->name('settings');
    Route::put('/settings/password', [DasborController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/notifications', [DasborController::class, 'updateNotificationSettings'])->name('settings.notifications');
});

Route::resource('penjualans', \App\Http\Controllers\PenjualanController::class);
Route::resource('penjualans', PenjualanController::class)->names([
    'index' => 'penjualans.index',
    'create' => 'penjualans.create',
    'store' => 'penjualans.store',
    'show' => 'penjualans.show',
    'edit' => 'penjualans.edit',
    // 'update' => 'penjualans.update', // bagian ini methode PUT tidak bekerja
    'destroy' => 'penjualans.destroy',
]);

Route::get('/', function () {
    // return view('welcome');
    return redirect()->to('login');
});
