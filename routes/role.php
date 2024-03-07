<?php

use App\Http\Controllers\Role\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('role', [RoleController::class, 'index'])
        ->name('role');

    Route::get('role/create', [RoleController::class, 'create']);
    Route::post('role/create', [RoleController::class, 'store'])->name('role.create');

});
