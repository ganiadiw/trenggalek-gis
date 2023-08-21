<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(string $orderBy, string $orderType): Collection;

    public function getAllWithCountTouristDestination(): Collection;

    public function getAllWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function create(array $data): Category;

    public function update(Category $category, array $data): bool;

    public function delete(Category $category): bool;
}
