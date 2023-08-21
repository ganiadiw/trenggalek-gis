<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRespositoryInterface
{
    public function getAllWithPaginate(string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function search(string $columnName, string $searchValue, string $orderBy, string $orderType, int $perPage): LengthAwarePaginator;

    public function create(array $data): User;

    public function update(User $user, array $data): bool;

    public function delete(User $user): bool;
}
