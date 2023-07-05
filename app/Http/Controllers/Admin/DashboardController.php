<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'webgisAdministratorsCount' => User::count(),
            'subDistricts' => SubDistrict::select('name', 'code', 'latitude', 'longitude', 'geojson_name', 'fill_color')->withCount('touristDestinations')->get(),
            'categories' => Category::select('name')->withCount('touristDestinations')->get(),
            'touristDestinations' => TouristDestination::with('category:id,name,marker_text_color,custom_marker_name,custom_marker_path')->select('id', 'category_id', 'slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')->get(),
        ]);
    }
}
