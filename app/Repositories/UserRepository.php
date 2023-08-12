<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRespositoryInterface
{
    public function getAllWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return User::query()->select('name', 'avatar_name', 'username', 'email', 'is_admin')
                    ->orderBy('is_admin', 'desc')->orderBy($orderBy, $orderType)->paginate($perPage);
    }

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator
    {
        return User::query()->select('name', 'avatar_name', 'username', 'email', 'is_admin')
                    ->where($columnName, 'like', '%' . $searchValue . '%')
                    ->orderBy('is_admin', 'desc')->orderBy($orderBy, $orderType)
                    ->paginate($perPage)->withQueryString();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
