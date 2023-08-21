<?php

namespace App\Services;

use App\Models\GuestPageSetting;
use App\Repositories\GuestPageSettingRespository;
use Illuminate\Support\Collection;

class GuestPageSettingService
{
    public function __construct(protected GuestPageSettingRespository $guestPageSettingRespository)
    {
    }

    public function getAll(string $orderBy = 'key', string $orderType = 'ASC'): Collection
    {
        return $this->guestPageSettingRespository->getAll($orderBy, $orderType);
    }

    public function getByKey(string $value, string $key = 'key'): GuestPageSetting
    {
        return $this->guestPageSettingRespository->getByKey($value, $key);
    }
}
