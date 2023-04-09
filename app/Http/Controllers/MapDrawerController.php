<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapDrawerController extends Controller
{
    public function __invoke()
    {
        return view('layouts.map-drawer');
    }
}
