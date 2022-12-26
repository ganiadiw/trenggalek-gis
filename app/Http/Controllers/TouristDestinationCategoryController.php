<?php

namespace App\Http\Controllers;

use App\Http\Requests\TouristDestinationCategoryRequest;
use App\Models\TouristDestinationCategory;

class TouristDestinationCategoryController extends Controller
{
    public function index()
    {
        $touristDestinationCategories = TouristDestinationCategory::select('id', 'name')
                                        ->orderBy('name', 'asc')->paginate(10);

        return view('tourist-destination-category.index', compact('touristDestinationCategories'));
    }

    public function create()
    {
        return view('tourist-destination-category.create');
    }

    public function store(TouristDestinationCategoryRequest $request)
    {
        TouristDestinationCategory::create($request->validated());

        return redirect(route('tourist-destination-categories.index'))->with('success', 'Data berhasil ditambahkan');
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

    public function edit(TouristDestinationCategory $touristDestinationCategory)
    {
        return view('tourist-destination-category.edit', compact('touristDestinationCategory'));
    }

    public function update(TouristDestinationCategoryRequest $request, TouristDestinationCategory $touristDestinationCategory)
    {
        $touristDestinationCategory->update($request->validated());

        return redirect(route('tourist-destination-categories.index'))->with('success', 'Data berhasil diperbarui');
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
