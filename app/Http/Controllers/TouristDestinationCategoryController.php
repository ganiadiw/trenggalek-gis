<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTouristDestinationCategoryRequest;
use App\Http\Requests\UpdateTouristDestinationCategoryRequest;
use App\Models\TouristDestinationCategory;

class TouristDestinationCategoryController extends Controller
{
    public function index()
    {
        $touristDestinationCategories = TouristDestinationCategory::select('id', 'name')
                                        ->orderBy('name', 'asc')->paginate(10);

        return view('tourist-destination-category.index', compact('touristDestinationCategories'));
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
     * @param  \App\Http\Requests\StoreTouristDestinationCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTouristDestinationCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TouristDestinationCategory  $touristDestinationCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TouristDestinationCategory $touristDestinationCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TouristDestinationCategory  $touristDestinationCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(TouristDestinationCategory $touristDestinationCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTouristDestinationCategoryRequest  $request
     * @param  \App\Models\TouristDestinationCategory  $touristDestinationCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTouristDestinationCategoryRequest $request, TouristDestinationCategory $touristDestinationCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TouristDestinationCategory  $touristDestinationCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TouristDestinationCategory $touristDestinationCategory)
    {
        //
    }
}
