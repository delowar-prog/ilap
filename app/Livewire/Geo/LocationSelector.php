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
    
    // Dropdown values (bound to select IDs)
    public $selectedCountryId = null;
    public $selectedStateId = null;
    public $selectedCityId = null;

    // Text box values (bound to input names, submitted values)
    public $selectedCountryName = null;
    public $selectedStateName = null;
    public $selectedCityName = null;

    // Submitted field names (optional, defaults to standard)
    public $countryFieldName = 'country';
    public $stateFieldName = 'state';
    public $cityFieldName = 'city';

    public $stateColClass = 'col-md-4';
    public $cityColClass = 'col-md-4';
    public $countryColClass = 'col-md-4';

    public $showPostCode = false;
    public $postCode = null;
    public $postCodeFieldName = 'post_code';

    public function mount(
        $initialCountry = null, 
        $initialState = null, 
        $initialCity = null, 
        $countryField = 'country', 
        $stateField = 'state', 
        $cityField = 'city', 
        $stateColClass = 'col-md-4', 
        $cityColClass = 'col-md-4', 
        $countryColClass = 'col-md-4',
        $showPostCode = false,
        $initialPostCode = null,
        $postCodeField = 'post_code'
    ) {
        $this->countryFieldName = $countryField;
        $this->stateFieldName = $stateField;
        $this->cityFieldName = $cityField;

        $this->stateColClass = $stateColClass;
        $this->cityColClass = $cityColClass;
        $this->countryColClass = $countryColClass;

        $this->showPostCode = $showPostCode;
        $this->postCode = $initialPostCode;
        $this->postCodeFieldName = $postCodeField;

        $this->selectedCountryName = $initialCountry;
        $this->selectedStateName = $initialState;
        $this->selectedCityName = $initialCity;

        $this->loadCountries();
        $this->loadStates();
        $this->loadCities();
        
        if ($initialCountry) {
            $country = Country::where('name', $initialCountry)->orWhere('id', $initialCountry)->first();
            if ($country) {
                $this->selectedCountryId = $country->id;
                $this->selectedCountryName = $country->name;
                $this->filterStatesAndCities();
            }
        }

        if ($initialState) {
            $state = State::where('name', $initialState)->orWhere('id', $initialState)->first();
            if ($state) {
                $this->selectedStateId = $state->id;
                $this->selectedStateName = $state->name;
                $this->filterCities();
            }
        }

        if ($initialCity) {
            $city = City::where('name', $initialCity)->orWhere('id', $initialCity)->first();
            if ($city) {
                $this->selectedCityId = $city->id;
                $this->selectedCityName = $city->name;
            }
        }
    }

    public function loadCountries()
    {
        $this->countries = Country::where('status', 'active')->orderBy('name')->get(['id', 'name', 'iso2']);
    }

    public function loadStates()
    {
        $this->states = State::where('status', 'active')->orderBy('name')->get(['id', 'name']);
    }

    public function loadCities()
    {
        $this->cities = City::where('status', 'active')->orderBy('name')->get(['id', 'name']);
    }

    public function filterStatesAndCities()
    {
        if ($this->selectedCountryId) {
            $this->states = State::where('country_id', $this->selectedCountryId)
                ->where('status', 'active')
                ->orderBy('name')
                ->get(['id', 'name']);
                
            $this->cities = City::whereIn('state_id', $this->states->pluck('id'))
                ->where('status', 'active')
                ->orderBy('name')
                ->get(['id', 'name']);
        } else {
            $this->loadStates();
            $this->loadCities();
        }
    }

    public function filterCities()
    {
        if ($this->selectedStateId) {
            $this->cities = City::where('state_id', $this->selectedStateId)
                ->where('status', 'active')
                ->orderBy('name')
                ->get(['id', 'name']);
        } elseif ($this->selectedCountryId) {
            $this->filterStatesAndCities();
        } else {
            $this->loadCities();
        }
    }

    public function updatedSelectedCountryName($value)
    {
        if (empty($value)) {
            $this->selectedCountryId = null;
            $this->selectedStateName = null;
            $this->selectedCityName = null;
            $this->selectedStateId = null;
            $this->selectedCityId = null;
            $this->loadStates();
            $this->loadCities();
            return;
        }

        $country = Country::where('name', $value)->first();
        if ($country) {
            $this->selectedCountryId = $country->id;
            $this->filterStatesAndCities();
            $this->dispatch('country-selected', iso2: $country->iso2);
        }
    }

    public function updatedSelectedStateName($value)
    {
        if (empty($value)) {
            $this->selectedStateId = null;
            $this->selectedCityName = null;
            $this->selectedCityId = null;
            $this->filterCities();
            return;
        }

        $state = State::where('name', $value)->first();
        if ($state) {
            $this->selectedStateId = $state->id;
            
            // Auto-select country if not set
            if (!$this->selectedCountryId) {
                $country = Country::find($state->country_id);
                if ($country) {
                    $this->selectedCountryId = $country->id;
                    $this->selectedCountryName = $country->name;
                    $this->dispatch('country-selected', iso2: $country->iso2);
                }
            }
            
            $this->filterCities();
        }
    }

    public function updatedSelectedCityName($value)
    {
        if (empty($value)) {
            $this->selectedCityId = null;
            return;
        }

        $city = City::where('name', $value)->first();
        if ($city) {
            $this->selectedCityId = $city->id;

            // Auto-set state and country if not set
            $state = State::find($city->state_id);
            if ($state) {
                if (!$this->selectedStateId) {
                    $this->selectedStateId = $state->id;
                    $this->selectedStateName = $state->name;
                }

                if (!$this->selectedCountryId) {
                    $country = Country::find($state->country_id);
                    if ($country) {
                        $this->selectedCountryId = $country->id;
                        $this->selectedCountryName = $country->name;
                        $this->dispatch('country-selected', iso2: $country->iso2);
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.geo.location-selector');
    }
}