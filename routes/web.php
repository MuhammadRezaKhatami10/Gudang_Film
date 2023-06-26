<?php

use App\Http\Controllers\MoviesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//mendefinisikan rute HTTP GET untuk URL root ('/'). Ketika permintaan GET diterima pada URL root, metode 'index' dari kelas 'MoviesController' akan dipanggil.
Route::get('/', [MoviesController::class, 'index']);

//endefinisikan rute HTTP POST untuk URL '/movies'. Ketika permintaan POST diterima pada URL '/movies', 
//metode 'store' dari kelas 'MoviesController' akan dipanggil. Rute ini juga menerapkan middleware ('auth' dan 'verified') 
//yang memastikan pengguna terautentikasi dan terverifikasi sebelum memproses permintaan. Rute ini diberi nama 'create.movies'.
Route::post('/movies', [MoviesController::class, 'store'])->middleware(['auth', 'verified'])->name('create.movies');

//mendefinisikan rute HTTP GET untuk URL '/movies'. Ketika permintaan GET diterima pada URL '/movies', metode 'show' dari kelas 'MoviesController' akan dipanggil. 
Route::get('/movies', [MoviesController::class, 'show'])->middleware(['auth', 'verified'])->name('my.movies');

//mendefinisikan rute HTTP GET untuk URL '/movies/edit'. Ketika permintaan GET diterima pada URL '/movies/edit', metode 'edit' dari kelas 'MoviesController' akan dipanggil. 
Route::get('/movies/edit', [MoviesController::class, 'edit'])->middleware(['auth', 'verified'])->name('edit.movies');

//mendefinisikan rute HTTP POST untuk URL '/movies/update'. Ketika permintaan POST diterima pada URL '/movies/update', metode 'update' dari kelas 'MoviesController' akan dipanggil.
Route::post('/movies/update', [MoviesController::class, 'update'])->middleware(['auth', 'verified'])->name('update.movies');

//mendefinisikan rute HTTP POST untuk URL '/movies/delete'. Ketika permintaan POST diterima pada URL '/movies/delete', metode 'destroy' dari kelas 'MoviesController' akan dipanggil.
Route::post('/movies/delete', [MoviesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('delete.movies');

//mendefinisikan sebuah rute HTTP GET untuk URL '/dashboard'. Ketika permintaan GET diterima pada URL '/dashboard', fungsi closure (anonymous function) akan dieksekusi. 
//Fungsi ini mengembalikan respons menggunakan Inertia, sebuah metode render dari kelas 'Inertia', dengan parameter 'Dashboard'. 
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//middleware yang diterapkan adalah auth, yang memastikan bahwa pengguna harus terautentikasi sebelum dapat mengakses rute-rute di dalam grup ini.
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
