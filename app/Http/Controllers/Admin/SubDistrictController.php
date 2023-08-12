<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchByColumnRequest;
use App\Http\Requests\StoreSubDistrictRequest;
use App\Http\Requests\UpdateSubDistrictRequest;
use App\Models\Category;
use App\Models\SubDistrict;
use App\Services\SubDistrictService;
use App\Services\TouristDestinationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubDistrictController extends Controller
{
    const GEOJSON_PATH = 'geojson/';

    public function __construct(
        protected SubDistrictService $subDistrictService,
        protected TouristDestinationService $touristDestinationService
        ) {
    }

    public function index(): View
    {
        $subDistricts = $this->subDistrictService->getAllWithPaginate('name');

        return view('sub-district.index', compact('subDistricts'));
    }

    public function search(SearchByColumnRequest $request): View
    {
        $validated = $request->validated();

        $subDistricts = $this->subDistrictService->search($validated['column_name'], $validated['search_value'], 'name');

        return view('sub-district.index', compact('subDistricts'));
    }

    public function create(): View
    {
        return view('sub-district.create');
    }

    public function store(StoreSubDistrictRequest $request): RedirectResponse
    {
        $this->subDistrictService->create($request->validated());

        toastr()->success('Data berhasil ditambahkan', 'Sukses');

        return redirect(route('dashboard.sub-districts.index'));
    }

    public function show(SubDistrict $subDistrict): View
    {
        $subDistrict->load('touristDestinations:sub_district_id,id,name,category_id');
        $touristDestinationsId = $subDistrict->touristDestinations->pluck('category_id')->unique();

        $subDistrict['tourist_destinations_count'] = count($subDistrict->touristDestinations);
        $subDistrict['tourist_destination_categories_count'] = Category::whereIn('id', $touristDestinationsId)->count();

        return view('sub-district.show', compact('subDistrict'));
    }

    public function edit(SubDistrict $subDistrict): View
    {
        return view('sub-district.edit', compact('subDistrict'));
    }

    public function update(UpdateSubDistrictRequest $request, SubDistrict $subDistrict): RedirectResponse
    {
        $this->subDistrictService->update($subDistrict, $request->validated());

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return redirect()->route('dashboard.sub-districts.edit', ['sub_district' => $subDistrict]);
    }

    public function destroy(SubDistrict $subDistrict): RedirectResponse
    {
        abort_if(! auth()->user()->is_admin, 403);

        if ($subDistrict->loadCount(['touristDestinations'])->tourist_destinations_count > 0) {
            toastr()->warning('Terdapat data destinasi wisata, hapus atau ubah terlebih dahulu data destinasi wisata terkait', 'Data Tidak Dapat Dihapus');

            return redirect(route('dashboard.sub-districts.related-tourist-destination', ['sub_district' => $subDistrict]));
        }

        $this->subDistrictService->delete($subDistrict);

        toastr()->success('Data berhasil dihapus', 'Sukses');

        return back();
    }

    public function download(SubDistrict $subDistrict): StreamedResponse
    {
        return Storage::download($subDistrict->geojson_path);
    }

    public function relatedTouristDestination(SubDistrict $subDistrict): View
    {
        return view('sub-district.related-tourist-destination', [
            'touristDestinations' => $this->touristDestinationService->getBySubDistrictWithPaginate($subDistrict->id, 'name'),
            'touristDestinationMapping' => $this->touristDestinationService->getBySubDistrict($subDistrict->id, 'name'),
            'subDistrict' => $subDistrict,
        ]);
    }

    public function relatedTouristDestinationSearch(SubDistrict $subDistrict, SearchByColumnRequest $request): View
    {
        $validated = $request->validated();

        return view('sub-district.related-tourist-destination', [
            'touristDestinations' => $this->touristDestinationService->searchBySubDistrictWithPaginate($subDistrict->id, $validated['column_name'], $validated['search_value'], 'name'),
            'touristDestinationMapping' => $this->touristDestinationService->searchBySubDistrict($subDistrict->id, $validated['column_name'], $validated['search_value'], 'name'),
            'subDistrict' => $subDistrict,
        ]);
    }
}
