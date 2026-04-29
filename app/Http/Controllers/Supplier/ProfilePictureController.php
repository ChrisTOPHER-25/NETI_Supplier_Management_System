<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\ProfilePicture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePictureController extends Controller
{
    public function show(Request $request) {
        // Find who owns profile picture file name
        $profilePic = ProfilePicture::where('file_name', $request->profilePictureFileName)->firstOrFail();
        $user = User::findOrFail($profilePic->user_id);
        // Proceed if user is the owner of the request profile picture
        if ($user->id == Auth::user()->id) {
            $path = storage_path("app/profile-pictures/{$request->profilePictureFileName}");
            if (!Storage::exists("profile-pictures/{$request->profilePictureFileName}")) {
                abort(404);
            }
            return response()->file($path);
        // Otherwise, block user
        } else {
            abort(401);
        }
    }
}
