<?php

namespace App\Services;

use App\Models\TemporaryFile;
use App\Models\TouristAttraction;
use App\Models\TouristDestination;
use App\Repositories\TouristDestinationRespository;
use DOMDocument;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function create(array $data)
    {
        if (request()->file('cover_image')) {
            $imageCover = $this->saveCoverImage($data['cover_image']);
            $data = array_merge($data, $imageCover);
        }

        $touristDestination = $this->touristDestinationRespository->create($data);

        if (isset($data['tourist_attraction_names']) && $data['tourist_attraction_names'][0] != null) {
            (new TouristAttractionService())->create($touristDestination, $data['tourist_attraction_names'], $data['tourist_attraction_images'], $data['tourist_attraction_captions']);
        }

        $media = json_decode($data['media_files']);

        if ($media != null && $media->used_images != null) {
            $newImageSources = [];

            foreach ($media->used_images as $item) {
                $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();
                $newImageSource = $touristDestination->addMedia(storage_path('app/public/' . $temporaryFile->foldername . '/' . $temporaryFile->filename))
                    ->toMediaCollection('tourist-destinations');
                $temporaryFile->delete();
                array_push($newImageSources, $newImageSource->getUrl());
            }

            $dom = new DOMDocument();
            $dom->loadHTML($touristDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $imageTags = $dom->getElementsByTagName('img');

            $index = 0;
            foreach ($imageTags as $imageTag) {
                $newSrc = $newImageSources[$index];
                $imageTag->setAttribute('src', $newSrc);
                $index++;
            }

            $content = $dom->saveHTML();

            $touristDestination = TouristDestination::where('id', $touristDestination->id)->update([
                'description' => $content,
            ]);
        }

        if ($media != null && $media->unused_images != null) {
            foreach ($media->unused_images as $item) {
                $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();
                Storage::delete($temporaryFile->foldername . '/' . $temporaryFile->filename);
                $temporaryFile->delete();
            }
        }

        return $touristDestination;
    }

    public function update(TouristDestination $touristDestination, array $data)
    {
        if (request()->file('cover_image')) {
            $imageCover = $this->saveCoverImage($data['cover_image'], $touristDestination->cover_image_path);
            $data = array_merge($data, $imageCover);
        }

        $this->touristDestinationRespository->update($touristDestination, $data);

        if ($data['deleted_tourist_attractions'][0] != null) {
            $newArrayData = array_values(explode(',', $data['deleted_tourist_attractions'][0]));

            foreach ($newArrayData as $value) {
                $touristAttraction = TouristAttraction::find($value);
                Storage::delete($touristAttraction->image_path);
                $touristAttraction->delete();
            }
        }

        if (! empty($data['tourist_attraction_id'])) {
            foreach ($data['tourist_attraction_id'] as $key => $value) {
                TouristAttraction::where('id', $value)->update([
                    'name' => $data['tourist_attraction_names'][$key],
                    'caption' => $data['tourist_attraction_captions'][$key],
                ]);
            }
        }

        if (isset($data['new_tourist_attraction_names']) && $data['new_tourist_attraction_names'][0] != null) {
            (new TouristAttractionService())->create($touristDestination, $data['new_tourist_attraction_names'], $data['new_tourist_attraction_images'], $data['new_tourist_attraction_captions']);
        }

        $media = json_decode($data['media_files']);

        if ($media != null && $media->used_images != null) {
            $touristDestination->update([
                'description' => $this->changeImageSource($media->used_images, $touristDestination),
            ]);
        }

        if ($media != null && $media->unused_images != null) {
            $this->deleteUnusedImage($media->unused_images);
        }
    }

    public function delete(TouristDestination $touristDestination): bool
    {
        Storage::delete($touristDestination->cover_image_path);

        foreach ($touristDestination->touristAttractions as $item) {
            if (Storage::exists($item->image_path)) {
                Storage::delete($item->image_path);
            }
        }

        return $this->touristDestinationRespository->delete($touristDestination);
    }

    public function saveCoverImage($image, $oldImagePath = null)
    {
        $data['cover_image_name'] = $image->hashName();
        $data['cover_image_path'] = $image->storeAs('cover-images', $data['cover_image_name']);

        if ($oldImagePath && Storage::exists($oldImagePath)) {
            Storage::delete($oldImagePath);
        }

        return $data;
    }

    public function changeImageSource(array $usedImages, $touristDestination)
    {
        $newImageSources = [];

        foreach ($usedImages as $item) {
            $mediaLibrary = Media::where('file_name', $item->filename)->first();

            if (! $mediaLibrary) {
                $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();
                $newImageSource = $touristDestination->addMedia(storage_path('app/public/' . $temporaryFile->foldername . '/' . $temporaryFile->filename))
                    ->toMediaCollection('tourist-destinations');
                $temporaryFile->delete();
                array_push($newImageSources, $newImageSource->getUrl());
            }
        }

        $dom = new DOMDocument();
        $dom->loadHTML($touristDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        if (! empty($newImageSources)) {
            $imageTags = $dom->getElementsByTagName('img');

            $index = 0;
            foreach ($imageTags as $imageTag) {
                if (pathinfo($imageTag->getAttribute('src'), PATHINFO_FILENAME) == pathinfo($newImageSources[$index], PATHINFO_FILENAME)) {
                    $newSrc = $newImageSources[$index];
                    $imageTag->setAttribute('src', $newSrc);
                    $index++;
                }
            }
        }

        return $dom->saveHTML();
    }

    public function deleteUnusedImage(array $unusedImages)
    {
        collect($unusedImages)->map(function ($item) {
            $media = Media::where('file_name', $item->filename)->first();

            if ($media) {
                Storage::delete('app/public/media/' . $media->id . '/' . $media->file_name);
                $media->delete();
            }

            (new ImageService())->deleteTemporaryImage($item->filename);
        });
    }
}
