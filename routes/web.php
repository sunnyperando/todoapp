<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\StatusUpdateController;
use App\Http\Controllers\DashboardController;


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

Route::get('/search', [\App\Http\Controllers\Admin\SearchController::class, 'index'])
    ->name('admin.search');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    //  Profile 
    Route::get('/profile',        [UserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',   [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile',     [UserController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile', function () {
    return view('profile.show');
    })->name('profile.show');

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

        // Projects CRUD
    Route::resource('projects', ProjectController::class)->names('projects'); 
        // Tasks CRUD
    Route::resource('tasks', TaskController::class)->names('tasks');
    
    });

        // Status Updates — sub-resource of tasks (no index/show/edit routes)
    Route::post(
        'admin/tasks/{task}/updates',
        [StatusUpdateController::class, 'store']
    )->name('status-updates.store');

    Route::delete(
        'admin/tasks/{task}/updates/{update}',
        [StatusUpdateController::class, 'destroy']
    )->name('status-updates.destroy');

});

require __DIR__.'/auth.php';
