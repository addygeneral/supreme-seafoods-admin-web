<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="<?php echo e(URL::to('admin/promocode/update-' . $getpromocode->id)); ?>" method="post"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for=""><?php echo e(trans('labels.offer_name')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="offer_name"
                                                value="<?php echo e($getpromocode->offer_name); ?>" id="offer_name"
                                                placeholder="<?php echo e(trans('labels.offer_name')); ?>">
                                            <?php $__errorArgs = ['offer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.offer_type')); ?> <span
                                                            class="text-danger">*</span> </label>
                                                    <select class="form-select" name="offer_type">
                                                        <option value="" selected><?php echo e(trans('labels.select')); ?>

                                                        </option>
                                                        <option value="1"
                                                            <?php echo e($getpromocode->offer_type == '1' ? 'selected' : ''); ?>>
                                                            <?php echo e(trans('labels.fixed')); ?></option>
                                                        <option value="2"
                                                            <?php echo e($getpromocode->offer_type == '2' ? 'selected' : ''); ?>>
                                                            <?php echo e(trans('labels.percentage')); ?></option>
                                                    </select>
                                                    <?php $__errorArgs = ['offer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.discount')); ?> <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only" name="offer_amount"
                                                        value="<?php echo e($getpromocode->offer_amount); ?>" id="price"
                                                        placeholder="<?php echo e(trans('labels.discount')); ?>">
                                                    <?php $__errorArgs = ['offer_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for=""><?php echo e(trans('labels.usage_type')); ?>

                                                <span class="text-danger">*</span> </label>
                                            <select class="form-select" name="usage_type">
                                                <option value="" selected><?php echo e(trans('labels.select')); ?>

                                                </option>
                                                <option value="1"
                                                    <?php echo e($getpromocode->usage_type == '1' ? 'selected' : ''); ?>>
                                                    <?php echo e(trans('labels.once_time')); ?></option>
                                                <option value="2"
                                                    <?php echo e($getpromocode->usage_type == '2' ? 'selected' : ''); ?>>
                                                    <?php echo e(trans('labels.multiple_times')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['usage_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group" id="usage_limit_input">
                                            <label class="form-label"><?php echo e(trans('labels.usage_limit')); ?><span class="text-danger">* </span></label>
                                            <input type="text" class="form-control" name="usage_limit" value="<?php echo e($getpromocode->usage_limit); ?>" placeholder="<?php echo e(trans('labels.usage_limit')); ?>">
                                            <?php $__errorArgs = ['usage_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.offer_code')); ?>

                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" name="offer_code"
                                                        value="<?php echo e($getpromocode->offer_code); ?>" id="offer_code"
                                                        placeholder="<?php echo e(trans('labels.offer_code')); ?>">
                                                    <?php $__errorArgs = ['offer_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.min_amount')); ?>

                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only" name="min_amount"
                                                        value="<?php echo e($getpromocode->min_amount); ?>" id="min_amount"
                                                        placeholder="<?php echo e(trans('labels.min_amount')); ?>">
                                                    <?php $__errorArgs = ['min_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.start_date')); ?> <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="date" class="form-control" name="start_date"
                                                        value="<?php echo e($getpromocode->start_date); ?>" id="start_date"
                                                        placeholder="<?php echo e(trans('labels.start_date')); ?>">
                                                    <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.end_date')); ?> <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="date" class="form-control" name="expire_date"
                                                        value="<?php echo e($getpromocode->expire_date); ?>" id="expire_date"
                                                        placeholder="<?php echo e(trans('labels.expire_date')); ?>"
                                                        min="<?php echo date('Y-m-d') ?>">
                                                    <?php $__errorArgs = ['expire_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for=""><?php echo e(trans('labels.description')); ?> <span
                                                    class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="description" rows="4" id="description"
                                                placeholder="<?php echo e(trans('labels.description')); ?>"><?php echo e($getpromocode->description); ?></textarea>
                                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="form-group text-end">
                                        <a href="<?php echo e(URL::to('admin/promocode')); ?>"
                                            class="btn btn-outline-danger"><?php echo e(trans('labels.cancel')); ?></a>
                                        <button class="btn btn-primary"
                                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php elseif(Auth::user()->type == 5): ?>  type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
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
    <script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/promocode.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/promocode/edit.blade.php ENDPATH**/ ?>