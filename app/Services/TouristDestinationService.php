<?php

namespace App\Services;

use App\Models\TouristDestination;
use App\Repositories\TouristDestinationRespository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class TouristDestinationService
{
    public function __construct(protected TouristDestinationRespository $touristDestinationRespository)
    {
    }

    public function getBySubDistrictWithPaginate(string $subDistrictId, string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->touristDestinationRespository->getBySubDistrictWithPaginate($subDistrictId, $orderBy, $orderType, $perPage);
    }

    public function getBySubDistrict(string $subDistrictId, string $orderBy = 'name', string $orderType = 'ASC'): Collection
    {
        return $this->touristDestinationRespository->getBySubDistrict($subDistrictId, $orderBy, $orderType);
    }

    public function getWithCategoryWithPaginate(string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->touristDestinationRespository->getWithCategoryWithPaginate($orderBy, $orderType, $perPage);
    }

    public function getAll(string $orderBy = 'name', string $orderType = 'ASC'): Collection
    {
        return $this->touristDestinationRespository->getAll($orderBy, $orderType);
    }

    public function searchWithPaginate(string $columnName, string $searchValue, string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->touristDestinationRespository->searchWithPaginate($columnName, $searchValue, $orderBy, $orderType, $perPage);
    }

    public function search(string $columnName, string $searchValue, string $orderBy = 'name', string $orderType = 'ASC'): Collection
    {
        return $this->touristDestinationRespository->search($columnName, $searchValue, $orderBy, $orderType);
    }

    public function searchBySubDistrictWithPaginate(string $subDistrictId, string $columnName, string $searchValue, string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->touristDestinationRespository->searchBySubDistrictWithPaginate($subDistrictId, $columnName, $searchValue, $orderBy, $orderType, $perPage);
    }

    public function searchBySubDistrict(string $subDistrictId, string $columnName, string $searchValue, string $orderBy, string $orderType = 'ASC', int $perPage = 10): Collection
    {
        return $this->touristDestinationRespository->searchBySubDistrict($subDistrictId, $columnName, $searchValue, $orderBy, $orderType, $perPage);
    }

    public function delete(TouristDestination $touristDestination): bool
    {
        Storage::delete($touristDestination->cover_image_path);

        foreach($touristDestination->touristAttractions as $item) {
            if (Storage::exists($item->image_path)) {
                Storage::delete($item->image_path);
            }
        }

        return $this->touristDestinationRespository->delete($touristDestination);
    }
}
