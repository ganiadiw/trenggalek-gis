<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\TouristDestination;

class TouristDestinationController extends Controller
{
    public function __invoke(TouristDestination $touristDestination)
    {
        $touristDestination['facility'] = explode(', ', $touristDestination->facility);
        $touristDestination->load(['touristAttractions', 'category', 'subDistrict']);

        return view('tourist-destination.show', compact('touristDestination'));
    }
}
