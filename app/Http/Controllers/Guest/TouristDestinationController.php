<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\TouristDestination;

class TouristDestinationController extends Controller
{
    public function __invoke(TouristDestination $touristDestination)
    {
        return view('guest.tourist-destination.show', compact('touristDestination'));
    }
}
