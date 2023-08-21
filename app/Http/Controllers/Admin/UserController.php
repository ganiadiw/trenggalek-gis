<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchByColumnRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(): View
    {
        $users = $this->userService->getAllWithPaginate();

        return view('webgis-admin.index', compact('users'));
    }

    public function search(SearchByColumnRequest $request): View
    {
        $validated = $request->validated();

        $users = $this->userService->search($validated['column_name'], $validated['search_value']);

        return view('webgis-admin.index', compact('users'));
    }

    public function create(): View
    {
        return view('webgis-admin.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->create($request->validated());

        toastr()->success('Data berhasil ditambahkan', 'Sukses');

        return redirect(route('dashboard.users.index'));
    }

    public function show(User $user): View
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

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $this->userService->update($user, $request->validated());

        toastr()->success('Data berhasil diperbarui', 'Sukses');

        return redirect()->route('dashboard.users.edit', ['user' => $user]);
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->is_admin, 403);

        $this->userService->delete($user);

        toastr()->success('Data berhasil dihapus', 'Sukses');

        return back();
    }
}
