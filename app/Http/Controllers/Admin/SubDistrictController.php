<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubDistrictRequest;
use App\Models\SubDistrict;
use Illuminate\Http\Request;

class SubDistrictController extends Controller
{
    public function index()
    {
        $subDistricts = SubDistrict::orderBy('code', 'asc')->paginate(10);

        return view('sub-district.index', compact('subDistricts'));
    }

    public function create()
    {
        return view('sub-district.create');
    }

    public function store(StoreSubDistrictRequest $request)
    {
        $validated = $request->validated();

        $geojson = $validated['geojson'];
        $validated['geojson_name'] = $geojson->getClientOriginalName();
        $validated['geojson_path'] = $geojson->storeAs('public/geojson', $validated['geojson_name']);
        SubDistrict::create($validated);

        return redirect(route('sub-districts.index'))->with(['success' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubDistrict  $subDistrict
     * @return \Illuminate\Http\Response
     */
    public function show(SubDistrict $subDistrict)
    {
        return view('sub-district.show', compact('subDistrict'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubDistrict  $subDistrict
     * @return \Illuminate\Http\Response
     */
    public function edit(SubDistrict $subDistrict)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubDistrict  $subDistrict
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubDistrict $subDistrict)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubDistrict  $subDistrict
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubDistrict $subDistrict)
    {
        //
    }
}
