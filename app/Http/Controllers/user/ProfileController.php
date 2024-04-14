<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Media\MediaUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $avatarId = getUserMeta(Auth::id(), 'avatar');
        $avatar = getImageById($avatarId);

        if( !empty($avatar) ) {
            $avatar = asset('storage/media/' . basename($avatar));
        }

        if( empty($avatar) ) {
            $avatar = asset('images/avatar.png');
        }

        return view('user.profile', compact('avatar'));
    }

    public function profileUpdate(Request $request)
    {
        if ($request->hasFile('file')) {
            $mediaUploader = app()->make(MediaUploadController::class);
            $mediaResponse = $mediaUploader->uploadMedia($request);
            $content = $mediaResponse->getContent();
            $data = json_decode($content, true);
            $mediaId = $data['media_id'] ?? null;

            $userId = Auth::id();
            $metaKey = 'avatar';
            $metaValue = $mediaId;
            updateUserMeta($userId, $metaKey, $metaValue);
        }

        if($request->filled('password')){
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = Auth::user();
            $newPassword = Hash::make($request->password);
            if (!Hash::check($newPassword, $user->password)) {
                $user->password = $newPassword;
                $user->save();
            }
        }

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

}

