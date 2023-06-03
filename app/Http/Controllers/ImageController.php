<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use App\Models\TouristAttraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['image', 'mimes:png,jpg,jpeg'],
        ]);

        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        $folder = 'tmp/media/images';
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

    public function destroy($filename)
    {
        $temporaryFile = TemporaryFile::where('filename', $filename)->first();

        if ($temporaryFile) {
            Storage::delete($temporaryFile->foldername . '/' . $temporaryFile->filename);
            $temporaryFile->delete();

            return response()->json([
                'message' => 'Delete temporary file was successfully',
            ]);
        }
    }

    public function updateTouristAttraction(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'image' => ['image', 'mimes:png,jpg,jpeg'],
        ]);

        if ($request->file('image')) {
            $touristAttraction = TouristAttraction::where('id', $request->id)->first();
            $image = $request->file('image');
            $imageName = str()->random(5) . '-' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('tourist-attractions', $imageName);

            Storage::delete($touristAttraction->image_path);
            $touristAttraction->update([
                'image_name' => $imageName,
                'image_path' => $imagePath,
            ]);

            return response()->json([
                'message' => 'Update image was successfully',
                'image_name' => $imageName,
                'image_path' => $imagePath,
                'public_path' => asset('storage/tourist-attractions/' . $imageName),
            ]);
        }
    }
}
