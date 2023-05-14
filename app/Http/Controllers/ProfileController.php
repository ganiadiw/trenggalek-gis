<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $validated = $request->except(['password', 'password_confirmation']);

        if ($request->file('avatar')) {
            $avatar = $validated['avatar'];
            $validated['avatar_name'] = $avatar->hashName();
            $validated['avatar_path'] = $avatar->storeAs('public/avatars', $validated['avatar_name']);

            if ($user->avatar_path != null) {
                Storage::delete($user->avatar_path);
            }
        }

        if ($request->password) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
