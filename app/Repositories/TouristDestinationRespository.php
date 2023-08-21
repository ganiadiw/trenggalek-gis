<?php

namespace App\Repositories;

use App\Models\TouristDestination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TouristDestinationRespository implements TouristDestinationRepositoryInterface
{
    public function getBySubDistrictWithPaginate(string $subDistrictId, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return TouristDestination::query()->select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
                ->where('sub_district_id', $subDistrictId)
                ->orderBy($orderBy, $orderType)->paginate($perPage);
    }

    public function getBySubDistrict(string $subDistrictId, string $orderBy, string $orderType): Collection
    {
        return TouristDestination::query()->select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
                ->where('sub_district_id', $subDistrictId)
                ->orderBy($orderBy, $orderType)->get();
    }

    public function getWithCategoryWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return TouristDestination::with('category:id,name,marker_text_color,custom_marker_name,custom_marker_path')
            ->select('id', 'category_id', 'slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->orderBy($orderBy, $orderType)->paginate($perPage);
    }

    public function getAll(string $orderBy, string $orderType): Collection
    {
        return TouristDestination::with('category:id,name,marker_text_color,custom_marker_name,custom_marker_path')
            ->select('id', 'category_id', 'slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->orderBy($orderBy, $orderType)->get();
    }

    public function searchWithPaginate(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return TouristDestination::with('category:id,name,marker_text_color,custom_marker_name,custom_marker_path')->select('id', 'category_id', 'slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->where($columnName, 'like', '%' . $searchValue . '%')
            ->orderBy($orderBy, $orderType)->paginate($perPage)->withQueryString();
    }

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType): Collection
    {
        return TouristDestination::with('category:id,name,marker_text_color,custom_marker_name,custom_marker_path')->select('id', 'category_id', 'slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->where($columnName, 'like', '%' . $searchValue . '%')
            ->orderBy($orderBy, $orderType)->get();
    }

    public function searchBySubDistrictWithPaginate(string $subDistrictId, string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return TouristDestination::query()->select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
                ->where('sub_district_id', $subDistrictId)
                ->where($columnName, 'like', '%' . $searchValue . '%')
                ->orderBy($orderBy, $orderType)->paginate($perPage)->withQueryString();
    }

    public function searchBySubDistrict(string $subDistrictId, string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): Collection
    {
        return TouristDestination::query()->select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
                ->where('sub_district_id', $subDistrictId)
                ->where($columnName, 'like', '%' . $searchValue . '%')
                ->orderBy($orderBy, $orderType)->get();
    }

    public function create(array $data): TouristDestination
    {
        return TouristDestination::query()->create($data);
    }

    public function update(TouristDestination $touristDestination, array $data): bool
    {
        return $touristDestination->update($data);
    }

    public function delete(TouristDestination $touristDestination): bool
    {
        return $touristDestination->delete();
    }
}
