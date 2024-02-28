<div class="row my-3">
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="<?php echo e(request()->is('admin/orders*') ? URL::to('/admin/orders') : 'javascript:void(0)'); ?>">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.total_orders')); ?></p>
                            <h4><?php echo e(count($getorders)); ?></h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="<?php echo e(request()->is('admin/orders*') ? URL::to('/admin/orders?status=processing') : 'javascript:void(0)'); ?>">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-hourglass"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.processing')); ?></p>
                            <h4><?php echo e($totalprocessing); ?></h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="<?php echo e(request()->is('admin/orders*') ? URL::to('/admin/orders?status=completed') : 'javascript:void(0)'); ?>">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-check"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.completed')); ?></p>
                            <h4><?php echo e($totalcompleted); ?></h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php if(request()->is('admin/orders*')): ?>
        
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="<?php echo e(request()->is('admin/orders*') ? URL::to('/admin/orders?status=cancelled') : 'javascript:void(0)'); ?>">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-close"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.cancelled')); ?></p>
                            <h4><?php echo e($totalcancelled); ?></h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <?php if(request()->is('admin/report*')): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon">
                        <i class="fa-regular fa-money-bill-1-wave"></i>
                    </span>
                    <span class="text-end">
                        <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.revenue')); ?></p>
                        <h4><?php echo e(Helper::currency_format($totalearnings)); ?></h4>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH /opt/lampp/htdocs/s-admin-new/resources/views/admin/orders/statistics.blade.php ENDPATH**/ ?>