<?php

namespace App\Http\Controllers;

use App\Http\Requests\TouristDestinationCategoryRequest;
use App\Models\TouristDestinationCategory;
use Illuminate\Http\Request;

class TouristDestinationCategoryController extends Controller
{
    public function index()
    {
        $touristDestinationCategories = TouristDestinationCategory::select('id', 'name')
            ->orderBy('name', 'asc')->paginate(10);

        return view('tourist-destination-category.index', compact('touristDestinationCategories'));
    }

    public function search(Request $request)
    {
        $touristDestinationCategories = TouristDestinationCategory::where('name', 'like', '%' . $request->search . '%')
            ->select('id', 'name')->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('tourist-destination-category.index', compact('touristDestinationCategories'));
    }

    public function create()
    {
        return view('tourist-destination-category.create');
    }

    public function store(TouristDestinationCategoryRequest $request)
    {
        TouristDestinationCategory::create($request->validated());

        return redirect(route('dashboard.tourist-destination-categories.index'))->with('success', 'Data berhasil ditambahkan');
    }

    public function show(TouristDestinationCategory $touristDestinationCategory)
    {
        return view('tourist-destination-category.show', compact('touristDestinationCategory'));
    }

    public function edit(TouristDestinationCategory $touristDestinationCategory)
    {
        return view('tourist-destination-category.edit', compact('touristDestinationCategory'));
    }

    public function update(TouristDestinationCategoryRequest $request, TouristDestinationCategory $touristDestinationCategory)
    {
        $touristDestinationCategory->update($request->validated());

        return redirect(route('dashboard.tourist-destination-categories.index'))->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(TouristDestinationCategory $touristDestinationCategory)
    {
        $touristDestinationCategory->delete();

        return redirect(route('dashboard.tourist-destination-categories.index'))->with('success', 'Data berhasil dihapus');
    }
}
