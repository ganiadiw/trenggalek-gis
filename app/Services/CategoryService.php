<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRespository)
    {
    }

    public function getAll(string $orderBy = 'name', string $orderType = 'ASC'): Collection
    {
        return $this->categoryRespository->getAll($orderBy, $orderType);
    }

    public function getAllWithCountTouristDestination(): Collection
    {
        return $this->categoryRespository->getAllWithCountTouristDestination();
    }

    public function getAllWithPaginate(string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->categoryRespository->getAllWithPaginate($orderBy, $orderType, $perPage);
    }

    public function search(string $columnName, string $searchValue, string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->categoryRespository->search($columnName, $searchValue, $orderBy, $orderType, $perPage);
    }

    public function create(array $data): Category
    {
        if (isset($data['marker_text_color']) && request()->file('custom_marker')) {
            $customMarker = $data['custom_marker'];
            $data['custom_marker_name'] = $customMarker->hashName();
            $data['custom_marker_path'] = $customMarker->storeAs('categories/custom-marker', $data['custom_marker_name']);
        }

        return $this->categoryRespository->create($data);
    }

    public function update(Category $category, array $data): bool
    {
        if ($data['marker_text_color'] && isset($data['custom_marker'])) {
            $customMarker = $data['custom_marker'];
            $data['custom_marker_name'] = $customMarker->hashName();
            $data['custom_marker_path'] = $customMarker->storeAs('categories/custom-marker', $data['custom_marker_name']);

            if ($category->custom_marker_path) {
                Storage::delete($category->custom_marker_path);
            }
        }

        return $this->categoryRespository->update($category, $data);
    }

    public function delete(Category $category): bool
    {
        if (Storage::exists($category->custom_marker_path)) {
            Storage::delete($category->custom_marker_path);
        }

        return $this->categoryRespository->delete($category);
    }
}
