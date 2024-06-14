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

        if (! empty($avatar)) {
            $avatar = asset('storage/media/'.basename($avatar));
        }

        if (empty($avatar)) {
            $avatar = asset('images/avatar.png');
        }

        return view('user.profile', compact('avatar'));
    }

    /**
     * Update the authenticated user's profile.
     *
     * This method handles updating the user's profile picture and password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profileUpdate(Request $request)
    {
        // Check if a file is uploaded
        if ($request->hasFile('file')) {
            // Use the MediaUploadController to upload the media file
            $mediaUploader = app()->make(MediaUploadController::class);
            $mediaResponse = $mediaUploader->uploadMedia($request);
            $content = $mediaResponse->getContent();
            $data = json_decode($content, true);
            $mediaId = $data['media_id'] ?? null;

            // Update the user's avatar metadata
            $userId = Auth::id();
            $metaKey = 'avatar';
            $metaValue = $mediaId;
            updateUserMeta($userId, $metaKey, $metaValue);
        }

        // Check if a password is provided
        if ($request->filled('password')) {
            // Validate the new password
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Update the user's password if it's different from the current password
            $user = Auth::user();
            $newPassword = Hash::make($request->password);
            if (! Hash::check($newPassword, $user->password)) {
                $user->password = $newPassword;
                $user->save();
            }
        }

        // Redirect back to the user's profile with a success message
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }
}
