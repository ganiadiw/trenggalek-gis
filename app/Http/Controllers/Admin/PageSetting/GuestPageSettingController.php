<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuestSettingRequest;
use App\Models\GuestPageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestPageSettingController extends Controller
{
    public function index()
    {
        $settings = GuestPageSetting::select('id', 'key', 'value')->orderBy('key', 'ASC')->get();

        return view('page-setting.guest.index', compact('settings'));
    }

    public function edit(GuestPageSetting $guestPageSetting)
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
                $value->storeAs('public/page-settings/' . $guestPageSetting->key, $imageName);
                $newFilename[$key] = $imageName;

                if (Storage::exists('public/page-settings/' . $guestPageSetting->key . '/' . $guestPageSetting->value[$key])) {
                    Storage::delete('public/page-settings/' . $guestPageSetting->key . '/' . $guestPageSetting->value[$key]);
                }
            }

            if (count($existingFilename) != $guestPageSetting->max_value) {
                array_push($existingFilename, $newFilename);
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

        if ($guestPageSetting->input_type == 'text') {
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

        if (Storage::exists('public/page-settings/' . $key . '/' . $filename)) {
            $arrayKey = array_search($filename, $value);
            $value[$arrayKey] = null;

            $settings->update([
                'value' => $value,
            ]);
            Storage::delete('public/page-settings/' . $key . '/' . $filename);

            return response()->json([
                'message' => 'Delete image successfully',
            ]);
        }
    }
}