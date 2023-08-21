<?php

namespace App\Services;

use App\Models\TouristAttraction;

class TouristAttractionService
{
    public function create($touristDestination, array $touristAttractionNames, array $touristAttractionImages, array $touristAttractionCaptions)
    {
        foreach ($touristAttractionNames as $key => $value) {
            if ($value != null) {
                $tourisAttractionImage = $touristAttractionImages[$key];
                $tourisAttractionImageName = str()->random(5) . '-' . $tourisAttractionImage->getClientOriginalName();
                $tourisAttractionImagePath = $tourisAttractionImage->storeAs('tourist-attractions', $tourisAttractionImageName);

                TouristAttraction::create([
                    'tourist_destination_id' => $touristDestination->id,
                    'name' => $value,
                    'image_name' => $tourisAttractionImageName,
                    'image_path' => $tourisAttractionImagePath,
                    'caption' => $touristAttractionCaptions[$key],
                ]);
            }
        }
    }
}
