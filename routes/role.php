<?php

use App\Http\Controllers\Role\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('role', [RoleController::class, 'create'])
        ->name('role');

    Route::post('role', [RoleController::class, 'store']);
});
