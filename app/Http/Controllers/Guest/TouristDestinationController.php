<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\TouristDestination;

class TouristDestinationController extends Controller
{
    public function __invoke(TouristDestination $touristDestination)
    {
        $touristDestination['facility'] = explode(', ', $touristDestination->facility);
        $touristDestination->load([
            'touristAttractions',
            'category:id,name,marker_text_color,custom_marker_name,custom_marker_path',
            'subDistrict:id,code,name,latitude,longitude,geojson_path,geojson_name,fill_color',
        ]);

        return view('tourist-destination.show', compact('touristDestination'));
    }
}
