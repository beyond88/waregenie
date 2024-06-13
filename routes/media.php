<?php

use App\Http\Controllers\Media\MediaController;

Route::middleware('auth')->group(function () {
    Route::get('media', [MediaController::class, 'index'])
        ->name('media.media');
    Route::get('media/upload', [MediaController::class, 'addNewMedia'])
        ->name('media.new');
    Route::post('media/upload', [MediaController::class, 'uploadNewMedia'])->name('media.new');
    Route::delete('media/delete/{id}', [MediaController::class, 'deleteMedia'])->name('media.delete');
    Route::get('media/{id}', [MediaController::class, 'displaySingleMedia'])
        ->name('media.show');
    Route::get('media/edit/{id}', [MediaController::class, 'editMedia'])
        ->name('media.edit');

    Route::post('media/edit/{id}', [MediaController::class, 'updateMedia'])->name('media.update');

    Route::get('media/download/{filename}', function ($filename) {
        $path = public_path('storage/media/'.basename($filename));
        if (! file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    })->name('download.media');

});
