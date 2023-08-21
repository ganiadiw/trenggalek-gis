<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuestSettingRequest;
use App\Models\GuestPageSetting;
use App\Services\GuestPageSettingService;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GuestPageSettingController extends Controller
{
    const PAGE_SETTING_PATH = 'page-settings/';

    public function __construct(protected GuestPageSettingService $guestPageSettingService)
    {
    }

    public function index(): View
    {
        $settings = $this->guestPageSettingService->getAll();

        return view('page-setting.guest.index', compact('settings'));
    }

    public function edit(GuestPageSetting $guestPageSetting): View
    {
        return view('page-setting.guest.edit', compact('guestPageSetting'));
    }

    public function update(GuestSettingRequest $request, GuestPageSetting $guestPageSetting)
    {
        $validated = $request->validated();

        if ($request->hasFile('value_image')) {
            $existingFilename = $guestPageSetting->value;
            $newFilename = [];

            foreach ($validated['value_image'] as $key => $value) {
                $imageName = str()->random(2) . substr((time() - strtotime('June 8, 1995')), -5) . '-' . $value->getClientOriginalName();
                $value->storeAs(self::PAGE_SETTING_PATH . $guestPageSetting->key, $imageName);
                $newFilename[$key] = $imageName;

                if (Storage::exists(self::PAGE_SETTING_PATH . $guestPageSetting->key . '/' . $guestPageSetting->value[$key])) {
                    Storage::delete(self::PAGE_SETTING_PATH . $guestPageSetting->key . '/' . $guestPageSetting->value[$key]);
                }
            }

            foreach ($existingFilename as $key => $value) {
                if (array_key_exists($key, $newFilename)) {
                    $existingFilename[$key] = $newFilename[$key];
                }
            }

            $guestPageSetting->update([
                'value' => $existingFilename,
            ]);
        }

        if ($guestPageSetting->input_type == 'text' || $guestPageSetting->input_type == 'textarea') {
            $guestPageSetting->update([
                'value' => $validated['value_text'],
            ]);
        }

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return back();
    }

    public function deleteImage($key, $filename)
    {
        $settings = GuestPageSetting::where('key', $key)->first();
        $value = $settings->value;

        if (Storage::exists(self::PAGE_SETTING_PATH . $key . '/' . $filename)) {
            $arrayKey = array_search($filename, $value);
            $value[$arrayKey] = null;

            $settings->update([
                'value' => $value,
            ]);
            Storage::delete(self::PAGE_SETTING_PATH . $key . '/' . $filename);

            return response()->json([
                'message' => 'Delete image successfully',
            ]);
        }
    }
}
