<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'marker_text_color',
        'custom_marker_name',
        'custom_marker_path',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function touristDestinations()
    {
        return $this->hasMany(TouristDestination::class);
    }
}
