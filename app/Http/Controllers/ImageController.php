<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemporaryImageRequest;
use App\Http\Requests\UpdateTouristAttractionImageRequest;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function store(TemporaryImageRequest $request, ImageService $imageService): JsonResponse
    {
        $result = $imageService->storeTemporaryImage($request->validated(['image']));

        return response()->json($result);
    }

    public function destroy($filename): JsonResponse
    {
        $imageService = new ImageService();

        $result = $imageService->deleteTemporaryImage($filename);

        return response()->json($result);
    }

    public function updateTouristAttraction(UpdateTouristAttractionImageRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $imageService = new ImageService();

        $result = $imageService->updateTouristAttractionImage($validated['image'], $validated['id']);

        return response()->json($result);
    }
}
