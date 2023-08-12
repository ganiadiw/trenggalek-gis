<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\SubDistrictService;
use App\Services\TouristDestinationService;

class DashboardController extends Controller
{
    public function __construct(
        protected SubDistrictService $subDistrictService,
        protected TouristDestinationService $touristDestinationService,
        protected CategoryService $categoryService
    )
    {
    }

    public function __invoke()
    {
        return view('dashboard', [
            'webgisAdministratorsCount' => User::count(),
            'subDistricts' => $this->subDistrictService->getAllWithCountTouristDestination(),
            'categories' => $this->categoryService->getAllWithCountTouristDestination(),
            'touristDestinations' => $this->touristDestinationService->getAll(),
        ]);
    }
}
