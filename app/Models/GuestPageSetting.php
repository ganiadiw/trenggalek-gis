<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'input_type',
        'max_value',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    // protected function value(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }
}
