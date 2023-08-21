<?php

namespace App\Repositories;

use App\Models\SubDistrict;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SubDistrictRespository implements SubDistrictRespositoryInterface
{
    public function getAll(string $orderBy, string $orderType): Collection
    {
        return SubDistrict::select('id', 'name', 'geojson_name', 'fill_color', 'latitude', 'longitude')->orderBy($orderBy, $orderType)->get();
    }

    public function getAllWithCountTouristDestination(): Collection
    {
        return SubDistrict::query()->select('name', 'code', 'latitude', 'longitude', 'geojson_name', 'fill_color')->withCount('touristDestinations')->get();
    }

    public function getAllWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return SubDistrict::query()->select('name', 'code', 'latitude', 'longitude')
                ->orderBy($orderBy, $orderType)->withCount('touristDestinations')->paginate($perPage);
    }

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return SubDistrict::query()->select('id', 'name', 'code', 'latitude', 'longitude')
                ->where($columnName, 'like', '%' . $searchValue . '%')
                ->orderBy($orderBy, $orderType)->withCount('touristDestinations')->paginate($perPage)->withQueryString();
    }

    public function create(array $data): SubDistrict
    {
        return SubDistrict::query()->create($data);
    }

    public function update(SubDistrict $subDistrict, array $data): bool
    {
        return $subDistrict->update($data);
    }

    public function delete(SubDistrict $subDistrict): bool
    {
        return $subDistrict->delete();
    }
}
