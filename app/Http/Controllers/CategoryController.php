<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchByColumnRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function index(): View
    {
        $categories = $this->categoryService->getAllWithPaginate('name', 'ASC', 10);

        return view('category.index', compact('categories'));
    }

    public function search(SearchByColumnRequest $request): View
    {
        $validated = $request->validated();

        $categories = $this->categoryService->search($validated['column_name'], $validated['search_value'], 'name', 'ASC', 10);

        return view('category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create($request->validated());

        toastr()->success('Data berhasil ditambahkan', 'Sukses');

        return redirect(route('dashboard.categories.index'));
    }

    public function show(Category $category): View
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->update($category, $request->validated());

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return back();
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->delete($category);

        toastr()->success('Data berhasil dihapus', 'Sukses');

        return back();
    }
}
