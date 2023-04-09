<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristAttraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tourist_destination_id',
        'name',
        'image_name',
        'image_path',
        'caption',
    ];

    public function touristDestination()
    {
        return $this->belongsTo(TouristDestination::class);
    }
}
