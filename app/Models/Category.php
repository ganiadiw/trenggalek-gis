<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'svg_name',
    ];

    const COLORS = [
        [
            'name' => 'red',
            'label' => 'Red',
            'hex_code' => '#d63e2a',
        ],
        [
            'name' => 'darkred',
            'label' => 'Dark Red',
            'hex_code' => '#9e3235',
        ],
        [
            'name' => 'lightred',
            'label' => 'Light Red',
            'hex_code' => '#ff8b7c',
        ],
        [
            'name' => 'orange',
            'label' => 'Orange',
            'hex_code' => '#f1932f',
        ],
        [
            'name' => 'beige',
            'label' => 'Beige',
            'hex_code' => '#ffc98f',
        ],
        [
            'name' => 'green',
            'label' => 'Green',
            'hex_code' => '#71ae26',
        ],
        [
            'name' => 'darkgreen',
            'label' => 'Dark Green',
            'hex_code' => '#6f7f23',
        ],
        [
            'name' => 'lightgreen',
            'label' => 'Light Green',
            'hex_code' => '#b8f471',
        ],
        [
            'name' => 'blue',
            'label' => 'Blue',
            'hex_code' => '#37a8da',
        ],
        [
            'name' => 'darkblue',
            'label' => 'Dark Blue',
            'hex_code' => '#0065a0',
        ],
        [
            'name' => 'lightblue',
            'label' => 'Light Blue',
            'hex_code' => '#85d9ff',
        ],
        [
            'name' => 'purple',
            'label' => 'Purple',
            'hex_code' => '#cf51b7',
        ],
        [
            'name' => 'darkpurple',
            'label' => 'Dark Purple',
            'hex_code' => '#593869',
        ],
        [
            'name' => 'pink',
            'label' => 'Pink',
            'hex_code' => '#ff8fe8',
        ],
        [
            'name' => 'cadetblue',
            'label' => 'Cadet Blue',
            'hex_code' => '#416675',
        ],
        [
            'name' => 'white',
            'label' => 'White',
            'hex_code' => '#fbfbfb',
        ],
        [
            'name' => 'gray',
            'label' => 'Gray',
            'hex_code' => '#575757',
        ],
        [
            'name' => 'lightgray',
            'label' => 'Light Gray',
            'hex_code' => '#a3a3a3',
        ],
        [
            'name' => 'black',
            'label' => 'Black',
            'hex_code' => '#303030',
        ],
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
