<?php

namespace App\Services;

use App\Models\SubDistrict;
use App\Repositories\SubDistrictRespository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class SubDistrictService
{
    const GEOJSON_PATH = 'geojson/';

    public function __construct(protected SubDistrictRespository $subDistrictRespository)
    {
    }

    public function getAll(string $orderBy = 'name', string $orderType = 'ASC'): Collection
    {
        return $this->subDistrictRespository->getAll($orderBy, $orderType);
    }

    public function getAllWithCountTouristDestination()
    {
        return $this->subDistrictRespository->getAllWithCountTouristDestination();
    }

    public function getAllWithPaginate(string $orderBy, string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->subDistrictRespository->getAllWithPaginate($orderBy, $orderType, $perPage);
    }

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->subDistrictRespository->search($columnName, $searchValue, $orderBy, $orderType, $perPage);
    }

    public function create(array $data): SubDistrict
    {
        if (request()->file('geojson')) {
            $result = $this->saveGeojsonFile($data['geojson']);
        } else {
            $result = $this->saveGeojsonText($data['geojson_text_area'], $data['code']);
        }

        $data = array_merge($data, $result);

        return $this->subDistrictRespository->create($data);
    }

    public function update(SubDistrict $subDistrict, array $data): bool
    {
        if (request()->file('geojson')) {
            $result = $this->saveGeojsonFile($data['geojson']);
            $this->deleteGoejsonFileIfExist($subDistrict->geojson_path);
        }

        if (request()->geojson_text_area != null) {
            $result = $this->saveGeojsonText($data['geojson_text_area'], $data['code']);
            $this->deleteGoejsonFileIfExist($subDistrict->geojson_path);
        }

        $data = array_merge($data, $result);

        return $this->subDistrictRespository->update($subDistrict, $data);
    }

    public function saveGeojsonFile($geojsonFile): array
    {
        $data['geojson_name'] = str()->random(5) . '-' . $geojsonFile->getClientOriginalName();
        $data['geojson_path'] = $geojsonFile->storeAs('geojson', $data['geojson_name']);

        return $data;
    }

    public function saveGeojsonText(string $geojsonText, string $code): array
    {
        $data['geojson_name'] = str()->random(5) . '-' . $code . '.geojson';
        $data['geojson_path'] = self::GEOJSON_PATH . $data['geojson_name'];
        Storage::put(self::GEOJSON_PATH . $data['geojson_name'], $geojsonText);

        return $data;
    }

    public function deleteGoejsonFileIfExist(string $geojsonPath): void
    {
        if ($geojsonPath != null) {
            Storage::delete($geojsonPath);
        }
    }

    public function delete(SubDistrict $subDistrict): bool
    {
        $this->deleteGoejsonFileIfExist($subDistrict->geojson_path);

        return $this->subDistrictRespository->delete($subDistrict);
    }

    // public function getRelatedTouristDestination(SubDistrict $subDistrict): Collection
    // {
    //     // return [
    //     //     'touristDestinations' => $this->subDistrictRespository->getRelatedTouristDestination($subDistrict)->paginate(10),
    //     //     'touristDestinationMapping' => $this->subDistrictRespository->getRelatedTouristDestination($subDistrict)->get(),
    //     // ]
    //     return $this->subDistrictRespository->getRelatedTouristDestination($subDistrict);
    // }
}
