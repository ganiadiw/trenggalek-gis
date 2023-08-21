<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\GuestPageSettingService;
use App\Services\SubDistrictService;
use App\Services\TouristDestinationService;
use Illuminate\Contracts\View\View;

class WelcomeController extends Controller
{
    public function __construct(
        protected SubDistrictService $subDistrictService,
        protected CategoryService $categoryService,
        protected TouristDestinationService $touristDestinationService,
        protected GuestPageSettingService $guestPageSettingService
    ) {
    }

    public function index(): View
    {
        $heroImages = $this->guestPageSettingService->getByKey('hero_image');

        $heroImagesCount = count(array_filter($heroImages->value, function ($value) {
            return $value !== null;
        }));

        return view('welcome', [
            'pageTitle' => $this->guestPageSettingService->getByKey('page_title'),
            'welcomeMessage' => $this->guestPageSettingService->getByKey('welcome_message'),
            'shortDescription' => $this->guestPageSettingService->getByKey('short_description'),
            'heroImages' => $heroImages,
            'heroImagesCount' => $heroImagesCount,
            'aboutPage' => $this->guestPageSettingService->getByKey('about_page'),
            'subDistricts' => $this->subDistrictService->getAll(),
            'categories' => $this->categoryService->getAllWithCountTouristDestination(),
            'touristDestinations' => $this->touristDestinationService->getAll(),
        ]);
    }
}
