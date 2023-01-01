<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTouristDestinationRequest;
use App\Http\Requests\UpdateTouristDestinationRequest;
use App\Models\TouristDestination;

class TouristDestinationController extends Controller
{
    public function index()
    {
        $touristDestinations = TouristDestination::select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->orderBy('name', 'asc')->paginate(10);

        return view('tourist-destination.index', compact('touristDestinations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTouristDestinationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTouristDestinationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function show(TouristDestination $touristDestination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function edit(TouristDestination $touristDestination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTouristDestinationRequest  $request
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTouristDestinationRequest $request, TouristDestination $touristDestination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function destroy(TouristDestination $touristDestination)
    {
        //
    }
}
