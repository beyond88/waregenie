<?php

use App\Http\Controllers\Role\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('role', [RoleController::class, 'index'])
        ->name('role');

    Route::get('role/create', [RoleController::class, 'create']);
    Route::post('role/create', [RoleController::class, 'store'])->name('role.create');

    Route::get('role/{id}/edit', [RoleController::class, 'edit']);
    Route::put('role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
});
