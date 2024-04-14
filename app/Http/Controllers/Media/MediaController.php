<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Media;


class MediaController extends Controller
{
    public function index(): View
    {
        $media = Media::paginate(5);
        return view('media.media', compact('media'));
    }

    public function addNewMedia()
    {
        return view('media.new');
    }
}
