<?php

namespace App\Http\Controllers;

class MapDrawerController extends Controller
{
    public function __invoke()
    {
        return view('layouts.map-drawer');
    }
}
