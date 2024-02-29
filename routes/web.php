<?php

use App\Http\Controllers\CoWorkerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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




Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Index');
    });

    Route::resource('/users', UserController::class);

    Route::match(['put', 'patch'], '/users/profile/{user}', [UserController::class, 'profileupdate']);

    Route::resource('/profile', ProfileController::class);

    Route::resource('/roles', RoleController::class);

    Route::post('/roles/user', [RoleController::class,'updateUserRole']);

    Route::resource('/coworkers', CoworkerController::class)->except(['index', 'show']);

    Route::get('/coworkers/{type?}', [CoworkerController::class, 'index'])->name('coworkers.index');


});
