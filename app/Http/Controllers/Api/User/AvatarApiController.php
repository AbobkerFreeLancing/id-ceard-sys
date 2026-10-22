<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        // Delete old avatar
        if ($user->profile_picture) {
            Storage::disk('public')
                ->delete($user->profile_picture);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('profile_pictures', 'public');


        $user->update([
            'profile_picture' => $path,
        ]);


        return response()->json([
            'message' => __('backend.profile_picture_updated_successfully'),
            'avatar_url' => asset('storage/' . $path),
        ]);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user->profile_picture) {
            // Delete the old profile_picture file
            Storage::disk('public')->delete($user->profile_picture);
            $user->update(['profile_picture' => null]);

            return response()->json(['message' => __('backend.profile_picture_deleted_successfully')]);
        }

        return response()->json(['message' => 'No profile picture to delete'], 400);
    }
}
