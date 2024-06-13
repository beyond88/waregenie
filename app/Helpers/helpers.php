<?php

use Illuminate\Support\Facades\Auth;

function is_route_active($routeName)
{
    return Str::contains(request()->url(), $routeName);
}

function getUserMeta($userId, $key)
{
    $userMeta = \App\Models\UserMeta::where('user_id', $userId)
        ->where('meta_key', $key)
        ->first();

    if ($userMeta) {
        return $userMeta->meta_value;
    }

    return null;
}

function updateUserMeta($userId, $key, $value)
{
    $userMeta = \App\Models\UserMeta::where('user_id', $userId)
        ->where('meta_key', $key)
        ->first();

    if ($userMeta) {
        $userMeta->update(['meta_value' => $value]);
    } else {
        \App\Models\UserMeta::create([
            'user_id' => $userId,
            'meta_key' => $key,
            'meta_value' => $value,
        ]);
    }

    return true;

}

function getImageById($id)
{
    $media = \App\Models\Media::find($id);
    if ($media) {
        return $media->media_name;
    }

    return null;
}

function getProfilePicture()
{

    $userId = Auth::id();
    $avatarId = getUserMeta($userId, 'avatar');
    if (! empty($avatarId)) {
        $avatar = getImageById($avatarId);

        return asset('storage/media/'.basename($avatar));
    }

    return null;

}

use App\Models\User;

function getUserRoleName($userId)
{

    $user = User::find($userId);

    if ($user) {
        $role = $user->role;

        if ($role) {
            return $role->name;
        } else {
            return 'Role not found';
        }
    } else {
        return 'User not found';
    }
}

function generateTextAvatar($fullName, $size = 100)
{

    $words = explode(' ', trim($fullName));

    $firstName = isset($words[0]) ? $words[0] : '';
    $firstInitial = strtoupper(substr($firstName, 0, 1));

    $lastName = isset($words[count($words) - 1]) ? $words[count($words) - 1] : '';
    $lastInitial = strtoupper(substr($lastName, 0, 1));

    $avatar = '<div class="text-avatar" style="width: '.$size.'px; height: '.$size.'px; line-height: '.$size.'px;">';
    $avatar .= '<span>'.$firstInitial.$lastInitial.'</span>';
    $avatar .= '</div>';

    echo $avatar;
}
