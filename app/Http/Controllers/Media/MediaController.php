<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        if ($search) {
            $media = Media::where('media_name', 'like', '%'.$search.'%')->paginate(30);
        } else {
            $media = Media::paginate(30);
        }

        return view('media.media', compact('media', 'search'));
    }

    public function addNewMedia()
    {
        return view('media.new');
    }

    public function uploadNewMedia(Request $request)
    {

        if ($request->hasFile('file')) {
            $mediaUploader = app()->make(MediaUploadController::class);
            $mediaResponse = $mediaUploader->uploadMedia($request);
            $content = $mediaResponse->getContent();
            $data = json_decode($content, true);
        }

        return redirect()->route('media.media')->with('success', 'Media uploaded successfully!');

    }

    public function deleteMedia($id)
    {

        $mediaUploader = app()->make(MediaUploadController::class);
        $mediaUploader->deleteMedia($id);

        return redirect()->route('media.media')->with('success', 'Media deleted successfully!');

    }

    public function showImageSize($image)
    {
        $imagePath = public_path('storage/media/'.basename($image));

        if (file_exists($imagePath)) {
            $size = filesize($imagePath);

            $humanReadableSize = $this->formatBytes($size);

            return $humanReadableSize;
        } else {
            return 'Image not found.';
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision).' '.$units[$pow];
    }

    public function displaySingleMedia($id): View
    {
        $media = Media::findOrFail($id);
        $imageSize = $this->showImageSize($media->media_name);

        // Get image dimensions
        $imagePath = public_path('storage/media/'.basename($media->media_name));
        if (File::exists($imagePath)) {
            [$width, $height] = getimagesize($imagePath);
        } else {
            $width = $height = null; // Provide fallback dimensions
        }

        // Extract the file extension
        $fileType = pathinfo($media->media_name, PATHINFO_EXTENSION);

        return view('media.details', compact('media', 'imageSize', 'fileType', 'width', 'height'));
    }

    public function editMedia($id): View
    {

        $media = Media::findOrFail($id);
        $imageSize = $this->showImageSize($media->media_name);

        // Get image dimensions
        $imagePath = public_path('storage/media/'.basename($media->media_name));
        if (File::exists($imagePath)) {
            [$width, $height] = getimagesize($imagePath);
        } else {
            $width = $height = null; // Provide fallback dimensions
        }

        // Extract the file extension and the file name without extension
        $fileNameWithoutExtension = pathinfo($media->media_name, PATHINFO_FILENAME);
        $fileType = pathinfo($media->media_name, PATHINFO_EXTENSION);

        return view('media.edit', compact('media', 'imageSize', 'fileType', 'width', 'height', 'fileNameWithoutExtension'));
    }

    public function updateMedia(Request $request, $id)
    {

        $request->validate([
            'media_name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,ico,webp,pdf,doc,docx,ppt,pptx,ods,xls,xlsx,psd,xml,mp3,m4a,ogg,wav,mp4,m4v,mov,wmv,avi,mpg,ogv,3gp,3g2,zip,rar,7z',
        ]);

        $media = Media::findOrFail($id);

        $oldExtension = pathinfo($media->media_name, PATHINFO_EXTENSION);
        $newMediaName = $request->input('media_name').'.'.$oldExtension;
        $media->media_name = $newMediaName;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $newFileName = $fileName.'_'.Str::random(10).'.'.$extension;
            $mediaUploader = app()->make(MediaUploadController::class);
            while ($mediaUploader->checkForDuplicate($fileName, $extension, $newFileName)) {
                $newFileName = $fileName.'_'.Str::random(10).'.'.$extension;
            }

            $file->storeAs('public/media', $newFileName);
            $media->media_name = $newFileName;
        }

        $media->save();

        return redirect()->route('media.show', ['id' => $media->id])
            ->with('success', 'Media updated successfully.');
    }
}
