<?php $__env->startSection('admin_contents'); ?>



<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-city me-2"></i> Cities Management
                </h6>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('cities.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add City
                </a>
            </div>
        </div>
    </div>

    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search city name..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="country_id" id="filter_country_id" class="form-select form-select-sm">
                        <option value="">All Countries</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($country->id); ?>" <?php echo e(request('country_id') == $country->id ? 'selected' : ''); ?>>
                                <?php echo e($country->name); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="state_id" id="filter_state_id" class="form-select form-select-sm">
                        <option value="">All States</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-1"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City Name</th>
                    <th>City Code</th>
                    <th>Status</th>
                    <th width="100" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td class="text-center"><?php echo e($cities->firstItem() + $loop->index); ?></td>
                        <td><?php echo e($city->country->name); ?></td>
                        <td><?php echo e($city->state->name); ?></td>
                        <td class="fw-semibold"><?php echo e($city->name); ?></td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary"><?php echo e($city->city_code ?? 'N/A'); ?></span></td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block m-0">
                                <input class="form-check-input global-status-toggle" 
                                       type="checkbox" 
                                       role="switch" 
                                       data-url="<?php echo e(route('status.toggle', ['modelType' => 'city', 'id' => $city->id])); ?>"
                                       <?php echo e($city->status == 'active' ? 'checked' : ''); ?> 
                                       style="cursor: pointer; width: 2.8em; height: 1.4em;">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="<?php echo e(route('cities.edit', $city->id)); ?>" class="dropdown-item py-1">
                                        <i class="fas fa-edit me-2 text-warning"></i>Edit
                                    </a>
                                    <form action="<?php echo e(route('cities.destroy', $city->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No City Found</h6>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer py-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    Showing <?php echo e($cities->firstItem() ?? 0); ?> - <?php echo e($cities->lastItem() ?? 0); ?> of <?php echo e($cities->total()); ?>

                </small>
            </div>
            <div class="col-md-6 text-end">
                <?php echo e($cities->withQueryString()->links()); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Filter Dropdown AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const filterCountry = document.getElementById('filter_country_id');
        const filterState = document.getElementById('filter_state_id');
        const initialFilterStateId = '<?php echo e(request('state_id')); ?>';

        function loadFilterStates(countryId, selectedStateId = '') {
            filterState.innerHTML = '<option value="">Loading...</option>';
            if (countryId) {
                fetch(`/geo/countries/${countryId}/states`)
                    .then(res => res.json())
                    .then(data => {
                        filterState.innerHTML = '<option value="">All States</option>';
                        data.forEach(state => {
                            let selected = state.id == selectedStateId ? 'selected' : '';
                            filterState.innerHTML += `<option value="${state.id}" ${selected}>${state.name}</option>`;
                        });
                    });
            } else {
                filterState.innerHTML = '<option value="">All States</option>';
            }
        }

        filterCountry.addEventListener('change', function() {
            loadFilterStates(this.value);
        });

        if (filterCountry.value) {
            loadFilterStates(filterCountry.value, initialFilterStateId);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\cities\index.blade.php ENDPATH**/ ?>