<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FetchAvailableContactsController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacationController;
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

    Route::resource('/contacts', ContactController::class);

    Route::resource('/projects', ProjectController::class);

    Route::resource('/tasks/{project}', TaskController::class)->except(['edit', 'update','show','destroy']);

    Route::get('/tasks/{task}/edit', [TaskController::class,'edit']);

    Route::delete('/tasks/{task}', [TaskController::class,'destroy']);

    Route::match(['put', 'patch'],'/tasks/{task}', [TaskController::class,'update']);

    Route::resource('/vacations/{contact}', VacationController::class)->except(['edit', 'show','update','destroy']);

    Route::get('/vacations/{vacation}/edit', [VacationController::class,'edit']);

    Route::match(['put', 'patch'],'/vacations/{vacation}', [VacationController::class,'update']);

    Route::delete('/vacations/{vacation}', [VacationController::class,'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->middleware('can_modify')->name('profile.edit');

    Route::match(['put', 'patch'], '/profile/{user}', [ProfileController::class, 'profileUpdate']);

    Route::match(['put', 'patch'], '/profile/{user}/password', [ProfileController::class, 'passwordUpdate']);

    Route::get('/fetch-available-contacts', FetchAvailableContactsController::class);

});
