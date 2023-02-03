<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTouristDestinationRequest;
use App\Http\Requests\UpdateTouristDestinationRequest;
use App\Models\SubDistrict;
use App\Models\TemporaryFile;
use App\Models\TouristDestination;
use App\Models\TouristDestinationCategory;
use DOMDocument;

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
        $touristDestination = TouristDestination::create($request->safe()->except(['media_files']));
        $mediaFiles = $request->safe()->only('media_files');
        $media = json_decode($mediaFiles['media_files']);

        if ($media->images != null) {
            $newImageSources = [];

            foreach ($media->images as $item) {
                $temporaryFile = TemporaryFile::where('filename', $item->filename)->first();
                $newImageSource = $touristDestination->addMedia(storage_path('app/public/tmp/media/' . $temporaryFile->foldername . '/' . $temporaryFile->filename))
                    ->toMediaCollection('tourist-destinations');
                rmdir(public_path('/storage/tmp/media/' . $temporaryFile->foldername));
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

        return redirect(route('tourist-destinations.index'))->with(['success' => 'Data berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function show(TouristDestination $touristDestination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function edit(TouristDestination $touristDestination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTouristDestinationRequest  $request
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTouristDestinationRequest $request, TouristDestination $touristDestination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TouristDestination  $touristDestination
     * @return \Illuminate\Http\Response
     */
    public function destroy(TouristDestination $touristDestination)
    {
        //
    }
}
