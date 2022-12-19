<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubDistrict;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $subDistricts = SubDistrict::all();

        return view('dashboard', compact('subDistricts'));
    }
}
