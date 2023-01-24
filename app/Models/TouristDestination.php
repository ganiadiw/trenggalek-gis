<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TouristDestination extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'sub_district_id',
        'tourist_destination_category_id',
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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getCoordinateAttribute()
    {
        return "{$this->latitude}, {$this->longitude}";
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function TouristDestinationCategory()
    {
        return $this->belongsTo(TouristDestinationCategory::class);
    }
}
