

<?php $__env->startSection('admin_contents'); ?>

<div class="card">

    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>
            Create Branch
        </h5>
         <a href="<?php echo e(route('branches.index')); ?>"
               class="btn btn-secondary">

                Back

            </a>
    </div>

    <form action="<?php echo e(route('branches.store')); ?>"
          method="POST"
          enctype="multipart/form-data">

        <?php echo csrf_field(); ?>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                    <input type="text"
                           name="branch_code"
                           class="form-control"
                           required>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Country <span class="text-danger">*</span></label>
                    <input type="text"
                           name="country"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text"
                           name="city"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Currency</label>

                    <select name="currency" class="form-select">
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                        <option value="BDT">BDT</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Timezone</label>

                    <select name="timezone" class="form-select">
                        <option value="Europe/London">
                            Europe/London
                        </option>

                        <option value="Asia/Dhaka">
                            Asia/Dhaka
                        </option>

                        <option value="America/New_York">
                            America/New_York
                        </option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Logo</label>

                    <input type="file"
                           name="logo"
                           class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Address</label>

                    <textarea name="address"
                              rows="3"
                              class="form-control"></textarea>
                </div>

            </div>

        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                Save Branch
            </button>

        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/branch/create.blade.php ENDPATH**/ ?>