<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'latitude',
        'longitude',
        'geojson_path',
        'geojson_name',
        'fill_color',
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function getCenterCoordinateAttribute()
    {
        return "{$this->latitude}, {$this->longitude}";
    }
}
