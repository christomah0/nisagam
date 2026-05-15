<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('photo')) {
            // Automatically streams the file directly to your GCS bucket
            $path = $request->file('photo')->store('photos', 'gcs');

            $url = config('filesystems.disks.gcs.url') . '/' . ltrim($path, '/');

            return response()->json([
                'message' => 'Photo successfully uploaded to GCS!',
                'url' => $url
            ], 200);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }
}
