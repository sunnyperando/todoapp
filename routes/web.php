<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',         [UserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',    [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update',  [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile',      [UserController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
