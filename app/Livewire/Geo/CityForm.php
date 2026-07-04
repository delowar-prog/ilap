<?php

namespace App\Livewire\Geo;

use Livewire\Component;
use App\Models\City;
use App\Models\Country;
use App\Models\State;

class CityForm extends Component
{
    public ?City $city = null;

    public $name = '';
    public $city_code = '';
    public $status = 'active';
    public $country_id = null;
    public $state_id = null;
    
    public $countries = [];
    public $states = [];

    protected $rules = [
        'name' => 'required|string|max:100',
        'city_code' => 'nullable|string|max:10',
        'country_id' => 'required|exists:countries,id',
        'state_id' => 'required|exists:states,id',
        'status' => 'required|in:active,inactive',
    ];

    public function mount(?City $city = null)
    {
        $this->countries = Country::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        if ($city && $city->exists) {
            $this->city = $city;
            $this->name = $city->name;
            $this->city_code = $city->city_code;
            $this->country_id = $city->country_id;
            $this->state_id = $city->state_id;
            $this->status = $city->status;

            // Load states for the initial country
            $this->states = State::where('country_id', $this->country_id)
                ->where('status', 'active')
                ->orderBy('name')
                ->get(['id', 'name']);
        }
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
    }

    public function save()
    {
        $this->validate();

        if ($this->city && $this->city->exists) {
            $this->city->update([
                'name' => $this->name,
                'city_code' => $this->city_code,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'status' => $this->status,
            ]);
            session()->flash('success', 'City updated successfully!');
        } else {
            City::create([
                'name' => $this->name,
                'city_code' => $this->city_code,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'status' => $this->status,
            ]);
            session()->flash('success', 'City created successfully!');
        }

        return redirect()->route('cities.index');
    }

    public function render()
    {
        return view('livewire.geo.city-form');
    }
}
