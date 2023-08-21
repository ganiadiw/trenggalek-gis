<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(string $orderBy, string $orderType): Collection
    {
        return Category::select('id', 'name')->orderBy($orderBy, $orderType)->get();
    }

    public function getAllWithCountTouristDestination(): Collection
    {
        return Category::select('id', 'name', 'marker_text_color', 'custom_marker_name', 'custom_marker_path')->withCount('touristDestinations')->get();
    }

    public function getAllWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return Category::query()->select('id', 'name', 'slug', 'marker_text_color', 'custom_marker_name', 'custom_marker_path')
                ->orderBy($orderBy, $orderType)->withCount('touristDestinations')->paginate($perPage);
    }

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return Category::query()->select('id', 'name', 'slug', 'marker_text_color', 'custom_marker_name', 'custom_marker_path')
                ->where($columnName, 'like', '%' . $searchValue . '%')
                ->orderBy($orderBy, $orderType)->withCount('touristDestinations')->paginate($perPage)->withQueryString();
    }

    public function create(array $data): Category
    {
        return Category::query()->create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
