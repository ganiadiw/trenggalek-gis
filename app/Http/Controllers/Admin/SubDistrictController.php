<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubDistrictRequest;
use App\Http\Requests\UpdateSubDistrictRequest;
use App\Models\SubDistrict;
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
        $subDistricts = SubDistrict::where('name', 'like', '%' . $request->search . '%')
            ->select('name', 'code', 'latitude', 'longitude')
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

        return redirect(route('dashboard.sub-districts.index'))->with(['success' => 'Data berhasil ditambahkan']);
    }

    public function show(SubDistrict $subDistrict)
    {
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

        return redirect(route('dashboard.sub-districts.index'))->with(['success' => 'Data berhasil diperbarui']);
    }

    public function destroy(SubDistrict $subDistrict)
    {
        abort_if(! auth()->user()->is_admin, 403);

        if ($subDistrict->geojson_path != null) {
            Storage::delete($subDistrict->geojson_path);
        }
        $subDistrict->delete();

        session()->flash('success', 'Data berhasil dihapus');

        return redirect(route('dashboard.sub-districts.index'));
    }

    public function download(SubDistrict $subDistrict)
    {
        return Storage::download($subDistrict->geojson_path);
    }
}
