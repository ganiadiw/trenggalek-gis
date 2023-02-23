<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTouristDestinationRequest;
use App\Http\Requests\UpdateTouristDestinationRequest;
use App\Models\SubDistrict;
use App\Models\TemporaryFile;
use App\Models\TouristDestination;
use App\Models\TouristDestinationCategory;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TouristDestinationController extends Controller
{
    public function index()
    {
        $touristDestinations = TouristDestination::select('slug', 'name', 'address', 'manager', 'distance_from_city_center', 'latitude', 'longitude')
            ->orderBy('name', 'asc')->paginate(10);

        return view('tourist-destination.index', compact('touristDestinations'));
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
            $imageCover = $validated['cover_image'];
            $validated['cover_image_name'] = $imageCover->hashName();
            $validated['cover_image_path'] = $imageCover->storeAs('public/cover-images', $validated['cover_image_name']);
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

        return redirect(route('tourist-destinations.index'))->with(['success' => 'Data berhasil ditambahkan']);
    }

    public function show(TouristDestination $touristDestination)
    {
        return view('tourist-destination.show', compact('touristDestination'));
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
            $imageCover = $validated['cover_image'];
            $validated['cover_image_name'] = $imageCover->hashName();
            $validated['cover_image_path'] = $imageCover->storeAs('public/cover-images', $validated['cover_image_name']);

            Storage::delete($touristDestination->cover_image_path);
        }

        $touristDestination->update($validated);
        $mediaFiles = $request->safe()->only('media_files');
        $media = json_decode($mediaFiles['media_files']);

        if ($media != null && $media->used_images != null) {
            $newImageSources = [];

            foreach ($media->used_images as $item) {
                $mediaLibrary = Media::where('file_name', $item->filename)->first();

                if (! $mediaLibrary) {
                    $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();
                    $newImageSource = $touristDestination->addMedia(storage_path('app/' . $temporaryFile->foldername . '/' . $temporaryFile->filename))
                        ->toMediaCollection('tourist-destinations');
                    $temporaryFile->delete();
                    array_push($newImageSources, $newImageSource->getUrl());
                }
            }

            if (! empty($newImageSources)) {
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

                $content = $dom->saveHTML();

                $touristDestination->update([
                    'description' => $content,
                ]);
            }
        }

        if ($media != null && $media->unused_images != null) {
            foreach ($media->unused_images as $item) {
                $mediaLibrary = Media::where('file_name', $item->filename)->first();

                if ($mediaLibrary) {
                    $mediaLibrary->delete();
                }

                $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();

                if ($temporaryFile) {
                    Storage::delete($temporaryFile->foldername . '/' . $temporaryFile->filename);
                    $temporaryFile->delete();
                }
            }
        }

        return redirect(route('tourist-destinations.index'))->with(['success' => 'Data berhasil diperbarui']);
    }

    public function destroy(TouristDestination $touristDestination)
    {
        $touristDestination->delete();

        return redirect(route('tourist-destinations.index'))->with(['success' => 'Data berhasil dihapus']);
    }
}
