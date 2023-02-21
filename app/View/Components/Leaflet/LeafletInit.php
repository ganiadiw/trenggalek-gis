<?php

namespace App\View\Components\Leaflet;

use Illuminate\View\Component;

class LeafletInit extends Component
{
    public $latitude;

    public $longitude;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($latitude = -8.13593475, $longitude = 111.64019829777817)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.leaflet.leaflet-init');
    }
}
