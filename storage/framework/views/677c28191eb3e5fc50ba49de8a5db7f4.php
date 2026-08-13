<div>
    <div class="row g-3">
        <?php
            $defaultCol = $showPostCode ? 'col-md-3' : 'col-md-4';
            $cityClass = ($cityColClass === 'col-md-4') ? $defaultCol : $cityColClass;
            $postCodeClass = $cityClass;
            $stateClass = ($stateColClass === 'col-md-4') ? $defaultCol : $stateColClass;
            $countryClass = ($countryColClass === 'col-md-4') ? $defaultCol : $countryColClass;
        ?>

        
        <div class="<?php echo e($cityClass); ?>" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'city-col-'.e($selectedStateName).'-'.e($selectedCityName).''; ?>wire:key="city-col-<?php echo e($selectedStateName); ?>-<?php echo e($selectedCityName); ?>">
            <label class="form-label">City</label>
            <select id="city-select-<?php echo e($this->getId()); ?>" 
                    name="<?php echo e($cityFieldName); ?>" 
                    class="form-select select2-location-select"
                    data-placeholder="Select city/district"
                    wire:model.change="selectedCityName">
                <option value=""></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedCityName && !collect($cities)->contains('name', $selectedCityName)): ?>
                    <option value="<?php echo e($selectedCityName); ?>" selected><?php echo e($selectedCityName); ?></option>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($city->name); ?>" <?php echo e($selectedCityName == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPostCode): ?>
            <div class="<?php echo e($postCodeClass); ?>" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'post-code-col'; ?>wire:key="post-code-col">
                <label class="form-label">Postal / Zip Code</label>
                <input type="text" 
                       name="<?php echo e($postCodeFieldName); ?>" 
                       class="form-control" 
                       value="<?php echo e($postCode); ?>"
                       placeholder="Postal / Zip Code">
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="<?php echo e($stateClass); ?>" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'state-col-'.e($selectedCountryName).'-'.e($selectedStateName).''; ?>wire:key="state-col-<?php echo e($selectedCountryName); ?>-<?php echo e($selectedStateName); ?>">
            <label class="form-label">State / Province</label>
            <select id="state-select-<?php echo e($this->getId()); ?>" 
                    name="<?php echo e($stateFieldName); ?>" 
                    class="form-select select2-location-select"
                    data-placeholder="Select state/province"
                    wire:model.change="selectedStateName">
                <option value=""></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedStateName && !collect($states)->contains('name', $selectedStateName)): ?>
                    <option value="<?php echo e($selectedStateName); ?>" selected><?php echo e($selectedStateName); ?></option>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($state->name); ?>" <?php echo e($selectedStateName == $state->name ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>

        
        <div class="<?php echo e($countryClass); ?>" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'country-col-'.e($selectedCountryName).''; ?>wire:key="country-col-<?php echo e($selectedCountryName); ?>">
            <label class="form-label">Country</label>
            <select id="country-select-<?php echo e($this->getId()); ?>" 
                    name="<?php echo e($countryFieldName); ?>" 
                    class="form-select select2-location-select"
                    data-placeholder="Select country"
                    wire:model.change="selectedCountryName">
                <option value=""></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedCountryName && !$countries->contains('name', $selectedCountryName)): ?>
                    <option value="<?php echo e($selectedCountryName); ?>" selected><?php echo e($selectedCountryName); ?></option>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($country->name); ?>" <?php echo e($selectedCountryName == $country->name ? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('d4d6c047-7f7a-4aee-8521-ed3952456e12')): $__env->markAsRenderedOnce('d4d6c047-7f7a-4aee-8521-ed3952456e12'); ?>
    <?php $__env->startPush('css'); ?>
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
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts'); ?>
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
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\iLap\resources\views/livewire/geo/location-selector.blade.php ENDPATH**/ ?>