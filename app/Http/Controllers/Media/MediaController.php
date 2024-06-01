<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Media;


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
}
