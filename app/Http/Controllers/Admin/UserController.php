<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('first_name', 'last_name', 'avatar_name', 'username', 'email', 'is_admin')
                ->orderBy('is_admin', 'desc')->orderBy('first_name', 'asc')->paginate(10);

        return view('webgis-admin.index', compact('users'));
    }

    public function search(Request $request)
    {
        $users = User::where('first_name', 'like', '%'.$request->search.'%')
                ->orWhere('last_name', 'like', '%'.$request->search.'%')
                ->orderBy('is_admin', 'desc')->orderBy('first_name', 'asc')
                ->paginate(10)->withQueryString();

        if (! $request) {
            $users = User::orderBy('is_admin', 'desc')->paginate(10);
        }

        return view('webgis-admin.index', compact('users'));
    }

    public function create()
    {
        return view('webgis-admin.create');
    }

    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect(route('users.index'))->with(['success' => 'Data berhasil ditambahkan']);
    }

    public function show(User $user)
    {
        return view('webgis-admin.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->is_admin) {
            return redirect(route('profile.edit'));
        }

        return view('webgis-admin.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validated();

        if ($request->file('avatar')) {
            $avatar = $validated['avatar'];
            $validated['avatar_name'] = $avatar->hashName();
            $validated['avatar_path'] = $avatar->storeAs('public/avatars', $validated['avatar_name']);

            if ($user->avatar_path != null) {
                Storage::delete($user->avatar_path);
            }
        }

        if (isset($validated['new_password']) == null || isset($validated['new_password']) == '') {
            $validated['password'] = $user->password;
            $user->update($validated);

            return redirect(route('users.index'))->with(['success' => 'Data berhasil diperbarui']);
        }

        if ($validated['password_confirmation'] != $validated['new_password']) {
            return back()->with(['error' => 'Konfirmasi password tidak sesuai'])->withInput();
        }

        $validated['password'] = Hash::make($validated['new_password']);
        $user->update($validated);

        return redirect(route('users.index'))->with(['success' => 'Data berhasil diperbarui']);
    }

    public function destroy(User $user)
    {
        abort_if($user->is_admin, 403);
        if ($user->avatar_path != null) {
            Storage::delete($user->avatar_path);
        }
        $user->delete();

        return redirect(route('users.index'))->with(['success' => 'Data berhasil dihapus']);
    }
}
