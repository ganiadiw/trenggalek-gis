<?php

namespace App\Repositories;

use App\Models\GuestPageSetting;
use Illuminate\Support\Collection;

interface GuestPageSettingRepositoryInterface
{
    public function getAll(string $orderBy, string $orderType): Collection;

    public function getByKey(string $value, string $key): GuestPageSetting;
}
