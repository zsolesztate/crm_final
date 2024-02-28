<?php

use App\Http\Controllers\ProfileController;
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

<<<<<<< Updated upstream
Route::get('/', function () {
    return Inertia::render('Index');
=======



Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Index');
    });

    Route::resource('/users', UserController::class);
    
    Route::match(['put', 'patch'], '/users/profile/{user}', [UserController::class, 'profileupdate']);



>>>>>>> Stashed changes
});
