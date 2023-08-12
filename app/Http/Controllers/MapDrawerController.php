<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MapDrawerController extends Controller
{
    public function __invoke(): View
    {
        return view('layouts.map-drawer');
    }
}
