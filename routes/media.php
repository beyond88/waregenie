<?php

use App\Http\Controllers\Media\MediaController;

Route::middleware('auth')->group(function () {
    Route::get('media', [MediaController::class, 'index'])
        ->name('media.media');
    Route::get('upload', [MediaController::class, 'addNewMedia'])
        ->name('media.new');
});
