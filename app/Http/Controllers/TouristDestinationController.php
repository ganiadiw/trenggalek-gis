<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTouristDestinationRequest;
use App\Http\Requests\UpdateTouristDestinationRequest;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use App\Models\TouristDestinationCategory;

class TouristDestinationController extends Controller
{
    public function index()
    {
        $touristDestinations = TouristDestination::select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->orderBy('name', 'asc')->paginate(10);

        return view('tourist-destination.index', compact('touristDestinations'));
    }

    public function create()
    {
        $subDistricts = SubDistrict::select('id', 'name')->orderBy('name', 'ASC')->get();
        $categories = TouristDestinationCategory::select('id', 'name')->orderBy('name', 'ASC')->get();

        return view('tourist-destination.create', compact('subDistricts', 'categories'));
    }

    public function store(StoreTouristDestinationRequest $request)
    {
        $validated = $request->validated();
        TouristDestination::create($validated);

        return redirect(route('tourist-destinations.index'))->with(['success' => 'Data berhasil ditambahkan']);
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
