<?php

use Illuminate\Support\Facades\Storage;
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
