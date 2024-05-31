<?php

use App\Http\Controllers\Media\MediaController;

Route::middleware('auth')->group(function () {
    Route::get('media', [MediaController::class, 'index'])
        ->name('media.media');
    Route::get('media/upload', [MediaController::class, 'addNewMedia'])
        ->name('media.new');
    Route::post('media/upload', [MediaController::class, 'uploadNewMedia'])->name('media.new');
    Route::delete('media/delete/{id}', [MediaController::class, 'deleteMedia'])->name('media.delete');

});
