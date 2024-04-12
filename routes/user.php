<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('user', [UserController::class, 'index'])
        ->name('user');

    Route::get('user/create', [UserController::class, 'create']);
    Route::post('user/create', [UserController::class, 'store'])->name('user.create');
    Route::get('user/{id}/edit', [UserController::class, 'edit']);
    Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('user/profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::post('user/profile', [ProfileController::class, 'profileUpdate'])->name('user.profile');
});
