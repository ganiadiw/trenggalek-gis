<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubDistrictRequest;
use App\Http\Requests\UpdateSubDistrictRequest;
use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\TouristDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubDistrictController extends Controller
{
    public function index(Request $request)
    {
        $subDistricts = SubDistrict::select('name', 'code', 'latitude', 'longitude')
            ->orderBy('code', 'asc')->paginate(10);

        return view('sub-district.index', compact('subDistricts'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'column_name' => 'required',
            'search_value' => 'required',
        ]);

        $subDistricts = SubDistrict::select('name', 'code', 'latitude', 'longitude')
            ->where($validated['column_name'], 'like', '%' . $validated['search_value'] . '%')
            ->orderBy('code', 'asc')->paginate(10)->withQueryString();

        return view('sub-district.index', compact('subDistricts'));
    }

    public function create()
    {
        return view('sub-district.create');
    }

    public function store(StoreSubDistrictRequest $request)
    {
        $validated = $request->validated();

        if ($request->file('geojson')) {
            $geojson = $validated['geojson'];
            $validated['geojson_name'] = Str::random(5) . '-' . $geojson->getClientOriginalName();
            $validated['geojson_path'] = $geojson->storeAs('public/geojson', $validated['geojson_name']);
        } else {
            $validated['geojson_name'] = Str::random(5) . '-' . $validated['code'] . '.geojson';
            Storage::put('public/geojson/' . $validated['geojson_name'], $request->geojson_text_area);
            $validated['geojson_path'] = 'public/geojson/' . $validated['geojson_name'];
        }

        SubDistrict::create($validated);

        toastr()->success('Data berhasil ditambahkan', 'Sukses');

        return redirect(route('dashboard.sub-districts.index'));
    }

    public function show(SubDistrict $subDistrict)
    {
        $subDistrict->load('touristDestinations:sub_district_id,id,name,category_id');
        $touristDestinationsId = $subDistrict->touristDestinations->pluck('category_id')->unique();

        $subDistrict['tourist_destinations_count'] = count($subDistrict->touristDestinations);
        $subDistrict['tourist_destination_categories_count'] = Category::whereIn('id', $touristDestinationsId)->count();

        return view('sub-district.show', compact('subDistrict'));
    }

    public function edit(SubDistrict $subDistrict)
    {
        return view('sub-district.edit', compact('subDistrict'));
    }

    public function update(UpdateSubDistrictRequest $request, SubDistrict $subDistrict)
    {
        $validated = $request->validated();

        if ($request->file('geojson')) {
            $geojson = $validated['geojson'];
            $validated['geojson_name'] = Str::random(5) . '-' . $geojson->getClientOriginalName();
            $validated['geojson_path'] = $geojson->storeAs('public/geojson', $validated['geojson_name']);

            if ($subDistrict->geojson_path != null) {
                Storage::delete($subDistrict->geojson_path);
            }
        }
        if ($request->geojson_text_area != null) {
            $validated['geojson_name'] = Str::random(5) . '-' . $validated['code'] . '.geojson';
            Storage::put('public/geojson/' . $validated['geojson_name'], $request->geojson_text_area);
            $validated['geojson_path'] = 'public/geojson/' . $validated['geojson_name'];

            if ($subDistrict->geojson_path != null) {
                Storage::delete($subDistrict->geojson_path);
            }
        }

        $subDistrict->update($validated);

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return redirect()->route('dashboard.sub-districts.edit', ['sub_district' => $subDistrict]);
    }

    public function destroy(SubDistrict $subDistrict)
    {
        abort_if(! auth()->user()->is_admin, 403);

        if ($subDistrict->loadCount(['touristDestinations'])->tourist_destinations_count > 0) {
            toastr()->warning('Terdapat data destinasi wisata, hapus atau ubah terlebih dahulu data destinasi wisata terkait', 'Data Tidak Dapat Dihapus');

            return redirect(route('dashboard.sub-districts.related-tourist-destination', ['sub_district' => $subDistrict]));
        }

        if ($subDistrict->geojson_path != null) {
            Storage::delete($subDistrict->geojson_path);
        }
        $subDistrict->delete();

        toastr()->success('Data berhasil dihapus', 'Sukses');

        return back();
    }

    public function download(SubDistrict $subDistrict)
    {
        return Storage::download($subDistrict->geojson_path);
    }

    public function relatedTouristDestination(SubDistrict $subDistrict)
    {
        $touristDestinations = TouristDestination::select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
                                ->where('sub_district_id', $subDistrict->id)
                                ->orderBy('name', 'asc');

        return view('sub-district.related-tourist-destination', [
            'touristDestinations' => $touristDestinations->paginate(10),
            'touristDestinationMapping' => $touristDestinations->get(),
            'subDistrict' => $subDistrict,
        ]);
    }

    public function relatedTouristDestinationSearch(SubDistrict $subDistrict, Request $request)
    {
        $validated = $request->validate([
            'column_name' => 'required',
            'search_value' => 'required',
        ]);

        $touristDestinations = TouristDestination::select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->where('sub_district_id', $subDistrict->id)
            ->where($validated['column_name'], 'like', '%' . $validated['search_value'] . '%')
            ->orderBy('name', 'asc');

        return view('sub-district.related-tourist-destination', [
            'touristDestinations' => $touristDestinations->paginate(10)->withQueryString(),
            'touristDestinationMapping' => $touristDestinations->get(),
            'subDistrict' => $subDistrict,
        ]);
    }
}
