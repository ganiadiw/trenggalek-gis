<?php

namespace App\Repositories;

use App\Models\TouristDestination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TouristDestinationRepositoryInterface
{
    public function getBySubDistrictWithPaginate(string $subDistrictId, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function getBySubDistrict(string $subDistrictId, string $orderBy, string $orderType): Collection;

    public function getWithCategoryWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function getAll(string $orderBy, string $orderType): Collection;

    public function searchWithPaginate(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType): Collection;

    public function searchBySubDistrictWithPaginate(string $subDistrictId, string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function searchBySubDistrict(string $subDistrictId, string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): Collection;

    public function create(array $data): TouristDestination;

    public function update(TouristDestination $touristDestination, array $data): bool;

    public function delete(TouristDestination $touristDestination): bool;
}
