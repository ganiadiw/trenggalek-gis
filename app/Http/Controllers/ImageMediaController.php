<?php

namespace App\Http\Controllers;

use App\Models\TouristDestination;

class ImageMediaController extends Controller
{
    public function touristDestinationDescriptionStore()
    {
        $touristDestination = new TouristDestination();
        $touristDestination->id = 0;
        $touristDestination->exists = true;
        $image = $touristDestination->addMediaFromRequest('file')->toMediaCollection('tourist-destinations');

        return response()->json([
            'location' => $image->getUrl(),
        ]);
    }
}
