<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GuestPageSetting;
use App\Models\SubDistrict;
use App\Models\TouristDestination;

class WelcomeController extends Controller
{
    public function index()
    {
        $heroImages = GuestPageSetting::where('key', 'hero_image')->select('key', 'value')->first();

        $heroImagesCount = count(array_filter($heroImages->value, function ($value) {
            return $value !== null;
        }));

        return view('welcome', [
            'pageTitle' => GuestPageSetting::where('key', 'page_title')->select('key', 'value')->first(),
            'welcomeMessage' => GuestPageSetting::where('key', 'welcome_message')->select('key', 'value')->first(),
            'shortDescription' => GuestPageSetting::where('key', 'short_description')->select('key', 'value')->first(),
            'heroImages' => $heroImages,
            'heroImagesCount' => $heroImagesCount,
            'aboutPage' => GuestPageSetting::where('key', 'about_page')->select('key', 'value')->first(),
            'subDistricts' => SubDistrict::select('name', 'geojson_path', 'geojson_name', 'fill_color', 'latitude', 'longitude')->get(),
            'categories' => Category::select('name', 'color', 'svg_name')->withCount('touristDestinations')->get(),
            'touristDestinations' => TouristDestination::with('category:id,name,color,svg_name,hex_code')->select('id', 'category_id', 'slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')->get(),
        ]);
    }
}
