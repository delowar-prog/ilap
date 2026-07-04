<div>
    <div class="row g-3">
        {{-- Country --}}
        <div class="col-md-6">
            <label class="form-label">Country <span class="text-danger">*</span></label>
            <select wire:model.live="country_id" class="form-select">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- State --}}
        <div class="col-md-6">
            <label class="form-label">State <span class="text-danger">*</span></label>
            <select wire:model.live="state_id" class="form-select" 
                    {{ !$country_id ? 'disabled' : '' }}>
                <option value="">
                    {{ !$country_id ? 'Select Country First' : 'Select State' }}
                </option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div> 
    </div>
</div>