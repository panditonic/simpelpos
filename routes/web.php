<?php

use App\Http\Controllers\DasborController;
use App\Http\Controllers\LoginController;
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
Route::get('dasbor',[DasborController::class, 'index']);
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
    // 'update' => 'produks.update',
    'destroy' => 'produks.destroy',
]);

Route::get('/', function () {
    // return view('welcome');
    return redirect()->to('login');
});
