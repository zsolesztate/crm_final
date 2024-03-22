<?php

use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return Inertia::render('Index');
    });

    Route::resource('/users', UserController::class)->except(['index', 'show']);

    Route::get('/users/{type?}', [UserController::class, 'index'])->name('users.index');

    Route::match(['put', 'patch'], '/users/{user}/password', [UserController::class, 'userPasswordUpdate']);

    Route::resource('/roles', RoleController::class);

    Route::post('/roles/user', [RoleController::class,'updateUserRole']);

    Route::resource('/partners', PartnerController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->middleware('can_modify')->name('profile.edit');

    Route::match(['put', 'patch'], '/profile/{user}', [ProfileController::class, 'profileUpdate']);

    Route::match(['put', 'patch'], '/profile/{user}/password', [ProfileController::class, 'passwordUpdate']);
});
