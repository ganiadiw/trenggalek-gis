<?php

namespace App\Repositories;

use App\Models\GuestPageSetting;
use Illuminate\Support\Collection;

class GuestPageSettingRespository implements GuestPageSettingRepositoryInterface
{
    public function getAll(string $orderBy, string $orderType): Collection
    {
        return GuestPageSetting::select('id', 'key', 'value', 'input_type')->orderBy($orderBy, $orderType)->get();
    }

    public function getByKey(string $value, string $key): GuestPageSetting
    {
        return GuestPageSetting::where($key, $value)->select('key', 'value')->first();
    }
}
