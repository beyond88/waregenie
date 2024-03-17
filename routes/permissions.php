<?php

use App\Http\Controllers\Role\PermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('permissions', [PermissionController::class, 'index'])
        ->name('permissions');
    Route::post('permissions', [PermissionController::class, 'store']);
    Route::get('permissions/load', [PermissionController::class, 'loadPermissions'])->name('permissions.load');
});
