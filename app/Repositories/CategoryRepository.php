<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
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
