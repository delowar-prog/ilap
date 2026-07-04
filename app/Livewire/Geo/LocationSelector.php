<?php

namespace App\Livewire\Geo;

use Livewire\Component;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class LocationSelector extends Component
{
    public $countries = [];
    public $states = [];
    public $cities = [];
    
    public $selectedCountry = null;
    public $selectedState = null;
    public $selectedCity = null;
    
    // Form submit হলে এই ডেটা পাঠানো হবে
    public $countryId = null;
    public $stateId = null;
    public $cityId = null;

    // Selected names for submission and ISO2 for preview
    public $selectedCountryName = null;
    public $selectedCountryIso2 = null;
    public $selectedCityName = null;

    public function mount()
    {
        $this->countries = Country::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    // Country পরিবর্তন হলে অটোমেটিক কল হবে
    public function updatedSelectedCountry($value)
    {
        $this->reset(['selectedState', 'selectedCity', 'states', 'cities', 'selectedCountryName', 'selectedCountryIso2', 'selectedCityName']);
        $this->countryId = $value;
        $this->stateId = null;
        $this->cityId = null;

        if ($value) {
            $country = Country::find($value);
            if ($country) {
                $this->selectedCountryName = $country->name;
                $this->selectedCountryIso2 = $country->iso2;
                $this->dispatch('country-selected', iso2: $country->iso2);
            }

            $this->states = State::where('country_id', $value)
                ->where('status', 'active')
                ->orderBy('name')
                ->get(['id', 'name']);
        }
    }

    // State পরিবর্তন হলে
    public function updatedSelectedState($value)
    {
        $this->reset(['selectedCity', 'cities', 'selectedCityName']);
        $this->stateId = $value;
        $this->cityId = null;

        if ($value) {
            $this->cities = City::where('state_id', $value)
                ->where('status', 'active')
                ->orderBy('name')
                ->get(['id', 'name']);
        }
    }

    public function updatedSelectedCity($value)
    {
        $this->cityId = $value;

        if ($value) {
            $city = City::find($value);
            $this->selectedCityName = $city?->name;
        } else {
            $this->selectedCityName = null;
        }
    }

    public function render()
    {
        return view('livewire.geo.location-selector');
    }
}