<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'slug', 'color', 'svg_name')
                        ->orderBy('name', 'asc')->withCount('touristDestinations')->paginate(10);

        return view('category.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'column_name' => 'required',
            'search_value' => 'required',
        ]);

        $categories = Category::select('id', 'name', 'slug', 'color', 'svg_name')
            ->where($validated['column_name'], 'like', '%' . $validated['search_value'] . '%')
            ->orderBy('name', 'asc')->withCount('touristDestinations')
            ->paginate(10)->withQueryString();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['color'])) {
            $matchedColor = collect(Category::COLORS)->first(function ($item) use ($validated) {
                return $item['name'] === $validated['color'];
            });
            $validated['hex_code'] = $matchedColor['hex_code'];
        }

        Category::create($validated);

        toastr()->success('Data berhasil ditambahkan', 'Sukses');

        return redirect(route('dashboard.categories.index'));
    }

    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        if (isset($validated['color'])) {
            $matchedColor = collect(Category::COLORS)->first(function ($item) use ($validated) {
                return $item['name'] === $validated['color'];
            });
            $validated['hex_code'] = $matchedColor['hex_code'];
        }

        $category->update($validated);

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();

        toastr()->success('Data berhasil dihapus', 'Sukses');

        return back();
    }
}
