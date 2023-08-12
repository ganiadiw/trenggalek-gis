<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function getAllWithPaginate(string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->getAllWithPaginate($orderBy, $orderType, $perPage);
    }

    public function search(string $columnName, string $searchValue, string $orderBy = 'name', string $orderType = 'ASC', int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->search($columnName, $searchValue, $orderBy, $orderType, $perPage);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data): bool
    {
        if (request()->file('avatar')) {
            $avatar = $data['avatar'];
            $data['avatar_name'] = $avatar->hashName();
            $data['avatar_path'] = $avatar->storeAs('avatars', $data['avatar_name']);

            if ($user->avatar_path != null) {
                $this->deleteUserImage($user->avatar_path);
            }
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        return $this->userRepository->update($user, $data);
    }

    public function delete(User $user): bool
    {
        if ($user->avatar_path != null) {
            $this->deleteUserImage($user->avatar_path);
        }

        return $this->userRepository->delete($user);
    }

    public function deleteUserImage($path)
    {
        Storage::delete($path);
    }
}
