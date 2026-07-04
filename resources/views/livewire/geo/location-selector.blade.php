<div>
    {{-- Hidden fields for standard form submission --}}
    <input type="hidden" name="country" value="{{ $selectedCountryName }}">
    <input type="hidden" name="city" value="{{ $selectedCityName }}">

    <div class="row g-3">
        {{-- Country --}}
        <div class="col-md-4">
            <label class="form-label">Country <span class="text-danger">*</span></label>
            <select wire:model.live="selectedCountry" class="form-select">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            @if($selectedCountryIso2)
                <div class="mt-1">
                    <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.75rem;">ISO2: {{ $selectedCountryIso2 }}</span>
                </div>
            @endif
        </div>

        {{-- State --}}
        <div class="col-md-4">
            <label class="form-label">State <span class="text-danger">*</span></label>
            <select wire:model.live="selectedState" class="form-select" 
                    {{ !$selectedCountry ? 'disabled' : '' }}>
                <option value="">
                    {{ !$selectedCountry ? 'Select Country First' : 'Select State' }}
                </option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- City --}}
        <div class="col-md-4">
            <label class="form-label">City <span class="text-danger">*</span></label>
            <select wire:model.live="selectedCity" class="form-select" 
                    {{ !$selectedState ? 'disabled' : '' }}>
                <option value="">
                    {{ !$selectedState ? 'Select State First' : 'Select City' }}
                </option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Debug Info (optional) --}}
    <div class="mt-3 small text-muted">
        Selected: Country ID: {{ $countryId ?? 'N/A' }}, 
        State ID: {{ $stateId ?? 'N/A' }}, 
        City ID: {{ $cityId ?? 'N/A' }}
    </div>
</div>