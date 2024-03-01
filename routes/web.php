<?php

use App\Http\Controllers\PartnerController;
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

    Route::match(['put', 'patch'], '/users/profile/{user}', [UserController::class, 'profileupdate']);

    Route::resource('/roles', RoleController::class);

    Route::post('/roles/user', [RoleController::class,'updateUserRole']);


    Route::resource('/partners', PartnerController::class);

    Route::get('/profile', function () {
        return Inertia::render('EditProfile',[
            'user' => Auth::user(),
        ]);
    });

});
