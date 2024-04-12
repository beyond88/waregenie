<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MediaUploadController;
use Illuminate\Support\Facades\Storage;

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
//        $avatar = Storage::disk('public')->temporaryUrl($avatar, now()->addMinutes(60));

        if( !empty($avatar) ) {
            $avatar = asset('storage/app/public/media/' . basename($avatar));
        }

        if(empty($avatar)) {
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
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048', // 2MB max
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user->profile()->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = Auth::user();
        $user->profile()->delete();

        return redirect()->route('profile.show')->with('success', 'Profile deleted successfully!');
    }
}

