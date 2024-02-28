<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="form-validation">
                        <form action="<?php echo e(URL::to('admin/addons/update-'.$addonsdata->id)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.name')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="name" id="addons_name"
                                            placeholder="<?php echo e(trans('labels.name')); ?>" value="<?php echo e($addonsdata->name); ?>">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.type')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <label class="radio-inline me-3"><input type="radio" name="type" value="1"
                                                onclick="get_price(this)" <?php echo e($addonsdata->price<=0 ? 'checked' : ''); ?>>
                                                <?php echo e(trans('labels.free')); ?></label>
                                        <label class="radio-inline me-3"><input type="radio" name="type" value="2"
                                                onclick="get_price(this)" <?php echo e($addonsdata->price>0 ? 'checked' : ''); ?>>
                                            <?php echo e(trans('labels.paid')); ?></label>
                                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <br><span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group <?php if($addonsdata->price<=0): ?> dn <?php endif; ?>" id="price_row">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.price')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="price" id="price"
                                            placeholder="<?php echo e(trans('labels.price')); ?>" value="<?php echo e($addonsdata->price); ?>">
                                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <a href="<?php echo e(URL::to('admin/addons')); ?>"
                                    class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                <button class="btn btn-primary" <?php if(env('Environment')=='sendbox' ): ?> type="button"
                                    onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/addons.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/addons/edit.blade.php ENDPATH**/ ?>