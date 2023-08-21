<?php

namespace App\Services;

use App\Models\TemporaryFile;
use App\Models\TouristAttraction;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function storeTemporaryImage($image): array
    {
        $filename = $image->getClientOriginalName();
        $folder = 'tmp/media/images';
        $path = $image->storeAs($folder, $filename);

        TemporaryFile::create([
            'foldername' => $folder,
            'filename' => $filename,
        ]);

        return [
            'location' => Storage::url($path),
            'filename' => $filename,
        ];
    }

    public function deleteTemporaryImage($filename): array
    {
        $temporaryFile = TemporaryFile::where('filename', $filename)->first();

        if ($temporaryFile) {
            Storage::delete($temporaryFile->foldername . '/' . $temporaryFile->filename);
            $temporaryFile->delete();

            return [
                'message' => 'Delete temporary file was successfully',
            ];
        }

        return [
            'message' => 'File not found or already deleted',
        ];
    }

    public function updateTouristAttractionImage($image, $touristAttractionImageId): array
    {
        $touristAttraction = TouristAttraction::where('id', $touristAttractionImageId)->first();
        $imageName = str()->random(5) . '-' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('tourist-attractions', $imageName);

        Storage::delete($touristAttraction->image_path);
        $touristAttraction->update([
            'image_name' => $imageName,
            'image_path' => $imagePath,
        ]);

        return [
            'message' => 'Update image was successfully',
            'image_name' => $imageName,
            'image_path' => $imagePath,
            'public_path' => asset('storage/tourist-attractions/' . $imageName),
        ];
    }
}
