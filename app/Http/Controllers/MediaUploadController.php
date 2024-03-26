<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InterventionImage\Image\Facades\Image;
use App\Models\Role;
use Illuminate\Support\Str;

class MediaUploadController extends Controller
{
    /**
     * Upload media file.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadMedia(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,ico,webp,pdf,doc,docx,ppt,pptx,ods,xls,xlsx,psd,xml,mp3,m4a,ogg,wav,mp4,m4v,mov,wmv,avi,mpg,ogv,3gp,3g2,zip,rar,7z',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        // Generate unique filename with random string if duplicate exists (in table or storage)
        $newFileName = $fileName . '_' . Str::random(10) . '.' . $extension;
        while ($this->checkForDuplicate($fileName, $extension, $newFileName)) {
            $newFileName = $fileName . '_' . Str::random(10) . '.' . $extension;
        }

        // Upload the file to the media directory
        $file->storeAs('public/media', $newFileName);

        // Insert data into the media table
        $mediaId = Media::create([
            'media_name' => $newFileName,
        ])->id;

        return response()->json(['media_id' => $mediaId]);
    }

    /**
     * Check for duplicate filename in media table and storage.
     *
     * @param string $fileName
     * @param string $extension
     * @param string $newFileName (optional)
     * @return bool
     */
    private function checkForDuplicate($fileName, $extension, $newFileName = null)
    {
        $existingMedia = Media::where('media_name', $fileName . '.' . $extension)->first();

        if ($existingMedia) {
            return true;
        }

        if ($newFileName) {
            return Storage::disk('public')->exists("media/$newFileName");
        }

        return Storage::disk('public')->exists("media/$fileName.$extension");
    }
}
