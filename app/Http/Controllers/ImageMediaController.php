<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageMediaController extends Controller
{
    public function touristDestinationDescriptionStore(Request $request)
    {
        $this->validate($request, [
            'image' => ['image', 'mimes:png,jpg,jpeg,gif'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $folder = 'public/tmp/media/images';
            $path = $image->storeAs($folder, $filename);

            TemporaryFile::create([
                'foldername' => $folder,
                'filename' => $filename,
            ]);

            return response()->json([
                'location' => Storage::url($path),
                'filename' => $filename,
            ]);
        }
    }
}
