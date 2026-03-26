<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController;

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

    //  Profile 
    Route::get('/profile',        [UserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',   [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile',     [UserController::class, 'destroy'])->name('profile.destroy');

    //  Admin 
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        // ROLE MIDDLEWARE HERE
        Route::middleware('role:admin')->group(function () {
            Route::resource('roles', RoleController::class);
        });

        Route::post('users/{user}/assign-roles', [RoleController::class, 'assignRole'])
            ->name('users.assignRole');

        // placeholders
        Route::get('products', fn() => view('coming-soon'))->name('products.index');
        Route::get('orders', fn() => view('coming-soon'))->name('orders.index');
        Route::get('payments', fn() => view('coming-soon'))->name('payments.index');
    });

});

require __DIR__.'/auth.php';
