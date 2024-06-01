<?php

namespace App\Http\Controllers\Media;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InterventionImage\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\Media;

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

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $newFileName = $fileName . '_' . Str::random(10) . '.' . $extension;
            while ($this->checkForDuplicate($fileName, $extension, $newFileName)) {
                $newFileName = $fileName . '_' . Str::random(10) . '.' . $extension;
            }

            $file->storeAs('public/media', $newFileName);

            $mediaId = Media::create([
                'media_name' => $newFileName,
            ])->id;

            return response()->json(['media_id' => $mediaId]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Upload failed'], 500);
        }
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

    /**
     * Delete media file.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMedia($id)
    {
        try {
            // Find the media record in the database
            $media = Media::findOrFail($id);
            $mediaName = $media->media_name;
            $filePath = "media/$mediaName";

            // Check if the file exists in the storage
            if (Storage::disk('public')->exists($filePath)) {
                // Delete the file from the storage
                Storage::disk('public')->delete($filePath);
            }

            // Delete the media record from the database
            $media->delete();

            $message = Storage::disk('public')->exists($filePath) ? 'Media deleted successfully!' : 'Media record deleted successfully, but the file was not found in storage.';
            $type = 'success';

            return redirect()->route('media.media')->with('message', $message)->with('type', $type);
        } catch (\Exception $e) {
            return redirect()->route('media.media')->with('message', 'Deletion failed: ' . $e->getMessage())->with('type', 'error');
        }
    }
}
