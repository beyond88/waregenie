<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InterventionImage\Image\Facades\Image;

class MediaUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => ['required', 'file', 'max:2048', 'mimes:jpeg,png,jpg,gif'], // Adjust validation rules as needed
            ]);

            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Generate a unique filename
            $filename = uniqid('', true) . '.' . $extension;

            // Use Intervention Image for resizing/manipulation (optional)
            $image = Image::make($file);
            // Perform any image manipulations (resize, watermark, etc.)
            // $image->resize(800, 600); // Example resize

            $image->save(storage_path('app/public/media/' . $filename)); // Adjust storage path as needed

            return response()->json([
                'success' => true,
                'filename' => $filename,
                'original_filename' => $originalFilename,
                'url' => Storage::url('media/' . $filename), // Adjust URL generation as needed
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
