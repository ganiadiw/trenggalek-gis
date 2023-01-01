<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_district_id',
        'name',
        'slug',
        'address',
        'manager',
        'description',
        'distance_from_city_center',
        'transportation_access',
        'facility',
        'latitude',
        'longitude',
    ];
}
