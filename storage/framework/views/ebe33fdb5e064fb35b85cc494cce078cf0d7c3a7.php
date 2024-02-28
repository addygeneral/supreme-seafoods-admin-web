<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="fa-regular fa-circle-exclamation"></i> <?php echo e(trans('labels.only_mobile')); ?>

            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" id="table-display">
                        <?php echo $__env->make('admin.notification.notificationtable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/s-admin-new/resources/views/admin/notification/notification.blade.php ENDPATH**/ ?>