<?php

namespace App\Repositories;

use App\Models\SubDistrict;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SubDistrictRespositoryInterface
{
    public function getAll(string $orderBy, string $orderType): Collection;

    public function getAllWithCountTouristDestination(): Collection;

    public function getAllWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function create(array $data): SubDistrict;

    public function update(SubDistrict $subDistrict, array $data): bool;

    public function delete(SubDistrict $subDistrict): bool;
}
