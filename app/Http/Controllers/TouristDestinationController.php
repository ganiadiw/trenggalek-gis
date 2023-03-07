<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTouristDestinationRequest;
use App\Http\Requests\UpdateTouristDestinationRequest;
use App\Models\SubDistrict;
use App\Models\TemporaryFile;
use App\Models\TouristDestination;
use App\Models\TouristDestinationCategory;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TouristDestinationController extends Controller
{
    public function index()
    {
        $touristDestinations = TouristDestination::select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->orderBy('name', 'asc');
        $subDistricts = SubDistrict::select('name', 'code', 'latitude', 'longitude', 'geojson_name', 'fill_color')
        ->orderBy('code', 'asc')->get();

        return view('tourist-destination.index', [
            'touristDestinations' => $touristDestinations->paginate(10),
            'touristDestinationMapping' => $touristDestinations->get(),
            'subDistricts' => $subDistricts,
        ]);
    }

    public function search(Request $request)
    {
        $touristDestinations = TouristDestination::where('name', 'like', '%' . $request->search . '%')
            ->orWhere('address', 'like', '%' . $request->search . '%')
            ->select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')->orderBy('name', 'asc');

        $subDistricts = SubDistrict::select('name', 'code', 'latitude', 'longitude', 'geojson_name', 'fill_color')
            ->orderBy('code', 'asc')->get();

        return view('tourist-destination.index', [
            'touristDestinations' => $touristDestinations->paginate(10)->withQueryString(),
            'touristDestinationMapping' => $touristDestinations->get(),
            'subDistricts' => $subDistricts,
        ]);
    }

    public function create()
    {
        $subDistricts = SubDistrict::select('id', 'name')->orderBy('name', 'ASC')->get();
        $categories = TouristDestinationCategory::select('id', 'name')->orderBy('name', 'ASC')->get();

        return view('tourist-destination.create', compact('subDistricts', 'categories'));
    }

    public function store(StoreTouristDestinationRequest $request)
    {
        $validated = $request->safe()->except(['media_files']);

        if ($request->file('cover_image')) {
            $coverImage = $validated['cover_image'];
            $validated['cover_image_name'] = $coverImage->hashName();
            $validated['cover_image_path'] = $coverImage->storeAs('public/cover-images', $validated['cover_image_name']);
        }

        $touristDestination = TouristDestination::create($validated);
        $mediaFiles = $request->safe()->only('media_files');
        $media = json_decode($mediaFiles['media_files']);

        if ($media != null && $media->used_images != null) {
            $newImageSources = [];

            foreach ($media->used_images as $item) {
                $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();
                $newImageSource = $touristDestination->addMedia(storage_path('app/' . $temporaryFile->foldername . '/' . $temporaryFile->filename))
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

            TouristDestination::where('id', $touristDestination->id)->update([
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

        toastr()->success('Data berhasil ditambahkan', 'Sukses');

        return redirect(route('dashboard.tourist-destinations.index'));
    }

    public function show(TouristDestination $touristDestination)
    {
        return redirect(route('guest.tourist-destinations.show', ['tourist_destination' => $touristDestination]));
    }

    public function edit(TouristDestination $touristDestination)
    {
        $touristDestination->load([
            'touristDestinationCategory:id,name',
            'subDistrict:id,name',
        ]);
        $subDistricts = SubDistrict::select('id', 'name')->orderBy('name', 'ASC')->get();
        $categories = TouristDestinationCategory::select('id', 'name')->orderBy('name', 'ASC')->get();

        return view('tourist-destination.edit', compact('touristDestination', 'subDistricts', 'categories'));
    }

    public function update(UpdateTouristDestinationRequest $request, TouristDestination $touristDestination)
    {
        $validated = $request->safe()->except(['media_files']);

        if ($request->file('cover_image')) {
            $coverImage = $validated['cover_image'];
            $validated['cover_image_name'] = $coverImage->hashName();
            $validated['cover_image_path'] = $coverImage->storeAs('public/cover-images', $validated['cover_image_name']);

            Storage::delete($touristDestination->cover_image_path);
        }

        $touristDestination->update($validated);
        $mediaFiles = $request->safe()->only('media_files');
        $media = json_decode($mediaFiles['media_files']);

        if ($media != null && $media->used_images != null) {
            $touristDestination->update([
                'description' => $this->changeImageSource($media->used_images, $touristDestination),
            ]);
        }

        if ($media != null && $media->unused_images != null) {
            $this->deleteUnusedImage($media->unused_images);
        }

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return back();
    }

    public function changeImageSource(array $usedImages, $touristDestination)
    {
        $newImageSources = [];

        foreach ($usedImages as $item) {
            $mediaLibrary = Media::where('file_name', $item->filename)->first();

            if (!$mediaLibrary) {
                $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();
                $newImageSource = $touristDestination->addMedia(storage_path('app/' . $temporaryFile->foldername . '/' . $temporaryFile->filename))
                    ->toMediaCollection('tourist-destinations');
                $temporaryFile->delete();
                array_push($newImageSources, $newImageSource->getUrl());
            }
        }

        if (!empty($newImageSources)) {
            $dom = new DOMDocument();
            $dom->loadHTML($touristDestination->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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

            (new ImageController)->destroy($item->filename);
        });
    }

    public function destroy(TouristDestination $touristDestination)
    {
        Storage::delete($touristDestination->cover_image_path);
        $touristDestination->delete();

        toastr()->success('Data berhasil dihapus', 'Sukses');

        return back();
    }
}
