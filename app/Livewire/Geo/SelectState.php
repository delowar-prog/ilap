<?php

namespace App\Livewire\Geo;

use Livewire\Component;
use App\Models\Country;
use App\Models\State;

class SelectState extends Component
{
    public $countries = [];
    public $states = [];

    public $country_id = null;
    public $state_id = null;
    
    public function mount()
    {
        $this->countries = Country::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function updatedCountryId($value)
    {
        $this->reset(['state_id', 'states']);

        if ($value) {
            $this->states = State::where('country_id', $value)
                ->where('status', 'active')
                ->orderBy('name')
                ->get(['id', 'name']);
        }
        
        $this->dispatch('countryChanged', countryId: $value);
        $this->dispatch('stateChanged', stateId: null);
    }
    
    public function updatedStateId($value)
    {
        $this->dispatch('stateChanged', stateId: $value);
    }

    public function render()
    {
        return view('livewire.geo.select-state');
    }
}