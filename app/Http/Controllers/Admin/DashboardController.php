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
        $webgisAdministrators = User::select('name', 'avatar_name', 'username', 'email', 'is_admin')->get();
        $subDistricts = SubDistrict::select('name', 'code', 'latitude', 'longitude', 'geojson_name', 'fill_color')->withCount('touristDestinations')->get();
        $categories = Category::select('name')->withCount('touristDestinations')->get();
        $touristDestinations = TouristDestination::with('category:id,name,icon_name')->select('id', 'category_id', 'slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')->get();

        return view('dashboard', compact('webgisAdministrators', 'subDistricts', 'categories', 'touristDestinations'));
    }
}
