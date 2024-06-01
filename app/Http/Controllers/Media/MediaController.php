<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(): View
    {
        $media = Media::paginate(30);
        return view('media.media', compact('media'));
    }

    public function addNewMedia()
    {
        return view('media.new');
    }

    public function uploadNewMedia(Request $request){

        if ($request->hasFile('file')) {
            $mediaUploader = app()->make(MediaUploadController::class);
            $mediaResponse = $mediaUploader->uploadMedia($request);
            $content = $mediaResponse->getContent();
            $data = json_decode($content, true);
        }

        return redirect()->route('media.new')->with('success', 'Media uploaded successfully!');

    }

    public function deleteMedia($id){

        $mediaUploader = app()->make(MediaUploadController::class);
        $mediaUploader->deleteMedia($id);
        return redirect()->route('media.media')->with('success', 'Media deleted successfully!');

    }

    public function showImageSize($image)
    {
        $imagePath = public_path('storage/media/' . basename($image));

        if (file_exists($imagePath)) {
            $size = filesize($imagePath);

            $humanReadableSize = $this->formatBytes($size);

            return $humanReadableSize;
        } else {
            return "Image not found.";
        }
    }

    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function displaySingleMedia($id): View{
        $media = Media::findOrFail($id);
        $imageSize = $this->showImageSize($media->media_name);
        return view('media.details', compact('media', 'imageSize'));
    }


}
