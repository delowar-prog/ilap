<div>
    <div class="row g-3">
        @php
            $defaultCol = $showPostCode ? 'col-md-3' : 'col-md-4';
            $cityClass = ($cityColClass === 'col-md-4') ? $defaultCol : $cityColClass;
            $postCodeClass = $cityClass;
            $stateClass = ($stateColClass === 'col-md-4') ? $defaultCol : $stateColClass;
            $countryClass = ($countryColClass === 'col-md-4') ? $defaultCol : $countryColClass;
        @endphp

        {{-- City --}}
        <div class="{{ $cityClass }}" wire:key="city-col-{{ $selectedStateName }}-{{ $selectedCityName }}">
            <label class="form-label">City</label>
            <select id="city-select-{{ $this->getId() }}" 
                    name="{{ $cityFieldName }}" 
                    class="form-select select2-location-select"
                    data-placeholder="Select city/district"
                    wire:model.change="selectedCityName">
                <option value=""></option>
                @if($selectedCityName && !collect($cities)->contains('name', $selectedCityName))
                    <option value="{{ $selectedCityName }}" selected>{{ $selectedCityName }}</option>
                @endif
                @foreach($cities as $city)
                    <option value="{{ $city->name }}" {{ $selectedCityName == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Post Code --}}
        @if($showPostCode)
            <div class="{{ $postCodeClass }}" wire:key="post-code-col">
                <label class="form-label">Postal / Zip Code</label>
                <input type="text" 
                       name="{{ $postCodeFieldName }}" 
                       class="form-control" 
                       value="{{ $postCode }}"
                       placeholder="Postal / Zip Code">
            </div>
        @endif

        {{-- State --}}
        <div class="{{ $stateClass }}" wire:key="state-col-{{ $selectedCountryName }}-{{ $selectedStateName }}">
            <label class="form-label">State / Province</label>
            <select id="state-select-{{ $this->getId() }}" 
                    name="{{ $stateFieldName }}" 
                    class="form-select select2-location-select"
                    data-placeholder="Select state/province"
                    wire:model.change="selectedStateName">
                <option value=""></option>
                @if($selectedStateName && !collect($states)->contains('name', $selectedStateName))
                    <option value="{{ $selectedStateName }}" selected>{{ $selectedStateName }}</option>
                @endif
                @foreach($states as $state)
                    <option value="{{ $state->name }}" {{ $selectedStateName == $state->name ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Country --}}
        <div class="{{ $countryClass }}" wire:key="country-col-{{ $selectedCountryName }}">
            <label class="form-label">Country</label>
            <select id="country-select-{{ $this->getId() }}" 
                    name="{{ $countryFieldName }}" 
                    class="form-select select2-location-select"
                    data-placeholder="Select country"
                    wire:model.change="selectedCountryName">
                <option value=""></option>
                @if($selectedCountryName && !$countries->contains('name', $selectedCountryName))
                    <option value="{{ $selectedCountryName }}" selected>{{ $selectedCountryName }}</option>
                @endif
                @foreach($countries as $country)
                    <option value="{{ $country->name }}" {{ $selectedCountryName == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@once
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container {
                display: block !important;
                width: 100% !important;
            }
            .select2-container .select2-selection--single {
                height: 38px !important;
                border: 1px solid #ced4da !important;
                border-radius: 0.25rem !important;
                display: flex !important;
                align-items: center !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: normal !important;
                padding-left: 12px !important;
                padding-right: 20px !important;
                width: 100% !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px !important;
                position: absolute !important;
                right: 8px !important;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                const initSelect2 = () => {
                    $('.select2-location-select').each(function () {
                        const element = $(this);
                        if (!element.hasClass("select2-hidden-accessible")) {
                            element.select2({
                                tags: true,
                                placeholder: element.attr('data-placeholder') || 'Select or type to add if not found...',
                                allowClear: true,
                                width: '100%'
                            }).on('change', function (e) {
                                this.dispatchEvent(new Event('input'));
                            });
                        }
                    });
                };

                initSelect2();

                // Re-init select2 after Livewire updates the DOM
                Livewire.hook('morph.updated', ({ el, component }) => {
                    initSelect2();
                });
            });
        </script>
    @endpush
@endonce