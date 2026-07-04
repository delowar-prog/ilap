<div class="card">
    <div class="card-header d-flex justify-content-between py-2">
        <h6 class="mb-0 fw-semibold text-uppercase d-flex align-items-center">
            <i class="fas {{ $city && $city->exists ? 'fa-edit' : 'fa-plus' }} me-2"></i>
            {{ $city && $city->exists ? 'Edit City: ' . $city->name : 'Create City' }}
        </h6>
        <a href="{{ route('cities.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form wire:submit.prevent="save">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Country <span class="text-danger">*</span></label>
                    <select wire:model.live="country_id" class="form-select @error('country_id') is-invalid @enderror">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">State <span class="text-danger">*</span></label>
                    <select wire:model.live="state_id" class="form-select @error('state_id') is-invalid @enderror" {{ !$country_id ? 'disabled' : '' }}>
                        <option value="">{{ !$country_id ? 'Select Country First' : 'Select State' }}</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    @error('state_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">City Name <span class="text-danger">*</span></label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter city name">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">City Code</label>
                    <input type="text" wire:model="city_code" class="form-control @error('city_code') is-invalid @enderror" placeholder="Enter city code">
                    @error('city_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                    <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="card-footer text-end py-2">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save me-1"></i> 
                {{ $city && $city->exists ? 'Update City' : 'Save City' }}
            </button>
        </div>
    </form>
</div>
