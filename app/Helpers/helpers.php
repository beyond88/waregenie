<?php

use Illuminate\Support\Facades\Auth;

/**
 * Check if the current route is active by matching the URL with the given route name.
 *
 * @param  string  $routeName
 * @return bool
 */
function is_route_active($routeName)
{
    return Str::contains(request()->url(), $routeName);
}

/**
 * Retrieve user meta data for a specific key.
 *
 * @param  int  $userId
 * @param  string  $key
 * @return mixed|null
 */
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

/**
 * Update or create user meta data for a specific key.
 *
 * @param  int  $userId
 * @param  string  $key
 * @param  mixed  $value
 * @return bool
 */
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

/**
 * Retrieve the name of a media item by its ID.
 *
 * @param  int  $id
 * @return string|null
 */
function getImageById($id)
{
    $media = \App\Models\Media::find($id);
    if ($media) {
        return $media->media_name;
    }

    return null;
}

/**
 * Get the profile picture URL of the currently authenticated user.
 *
 * @return string|null
 */
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

/**
 * Get the role name of a user by their ID.
 *
 * @param  int  $userId
 * @return string
 */
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

/**
 * Generate a text-based avatar using the initials of a user's full name.
 *
 * @param  string  $fullName
 * @param  int  $size
 * @return void
 */
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
