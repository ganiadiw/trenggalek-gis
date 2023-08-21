<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchByColumnRequest;
use App\Http\Requests\StoreTouristDestinationRequest;
use App\Http\Requests\UpdateTouristDestinationRequest;
use App\Models\TouristDestination;
use App\Services\CategoryService;
use App\Services\SubDistrictService;
use App\Services\TouristDestinationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TouristDestinationController extends Controller
{
    public function __construct(
        protected TouristDestinationService $touristDestinationService,
        protected SubDistrictService $subDistrictService,
        protected CategoryService $categoryService
        ) {
    }

    public function index(): View
    {
        return view('tourist-destination.index', [
            'touristDestinationsDataTable' => $this->touristDestinationService->getWithCategoryWithPaginate(),
            'touristDestinations' => $this->touristDestinationService->getAll(),
            'subDistricts' => $this->subDistrictService->getAllWithCountTouristDestination(),
        ]);
    }

    public function search(SearchByColumnRequest $request): View
    {
        $validated = $request->validated();

        return view('tourist-destination.index', [
            'touristDestinationsDataTable' => $this->touristDestinationService->searchWithPaginate($validated['column_name'], $validated['search_value']),
            'touristDestinations' => $this->touristDestinationService->search($validated['column_name'], $validated['search_value']),
            'subDistricts' => $this->subDistrictService->getAllWithCountTouristDestination(),
        ]);
    }

    public function create(): View
    {
        $subDistricts = $this->subDistrictService->getAll();
        $categories = $this->categoryService->getAll();

        return view('tourist-destination.create', compact('subDistricts', 'categories'));
    }

    public function store(StoreTouristDestinationRequest $request): RedirectResponse
    {
        $this->touristDestinationService->create($request->validated());

        toastr()->success('Data berhasil ditambahkan', 'Sukses');

        return redirect(route('dashboard.tourist-destinations.index'));
    }

    public function show(TouristDestination $touristDestination): RedirectResponse
    {
        return redirect(route('guest.tourist-destinations.show', ['tourist_destination' => $touristDestination]));
    }

    public function edit(TouristDestination $touristDestination): View
    {
        $touristDestination->load([
            'subDistrict:id,name',
            'category:id,name',
            'touristAttractions:id,tourist_destination_id,name,image_name,image_path,caption',
        ]);
        $subDistricts = $this->subDistrictService->getAll();
        $categories = $this->categoryService->getAll();

        return view('tourist-destination.edit', compact('touristDestination', 'subDistricts', 'categories'));
    }

    public function update(UpdateTouristDestinationRequest $request, TouristDestination $touristDestination): RedirectResponse
    {
        $this->touristDestinationService->update($touristDestination, $request->validated());

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return back();
    }

    public function destroy(TouristDestination $touristDestination): RedirectResponse
    {
        $this->touristDestinationService->delete($touristDestination);

        toastr()->success('Data berhasil dihapus', 'Sukses');

        return back();
    }
}
