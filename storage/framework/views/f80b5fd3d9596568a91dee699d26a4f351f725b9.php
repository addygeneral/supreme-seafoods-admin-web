<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="form-validation">
                        <form action="<?php echo e(URL::to('admin/driver/store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.name')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>"
                                            id="name" placeholder="<?php echo e(trans('labels.name')); ?>">
                                        <?php $__errorArgs = ['name'];
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
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.email')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="email" value="<?php echo e(old('email')); ?>"
                                            id="email" placeholder="<?php echo e(trans('labels.email')); ?>">
                                        <?php $__errorArgs = ['email'];
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
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.mobile')); ?> <span
                                        class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="mobile" value="<?php echo e(old('mobile')); ?>"
                                        id="mobile" placeholder="<?php echo e(trans('labels.mobile')); ?>">
                                        <?php $__errorArgs = ['mobile'];
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
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.password')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <input type="password" class="form-control" name="password"
                                            value="<?php echo e(old('password')); ?>" id="password"
                                            placeholder="<?php echo e(trans('labels.password')); ?>">
                                        <?php $__errorArgs = ['password'];
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
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.identity_type')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <select id="identity_type" name="identity_type" class="form-select"
                                            aria-label="">
                                            <option value="" selected disabled><?php echo e(trans('labels.select')); ?></option>
                                            <option value="Passport" <?php echo e(old('identity_type')=="Passport" ? 'selected'
                                                : ''); ?>> <?php echo e(trans('labels.passport')); ?> </option>
                                            <option value="Driving License" <?php echo e(old('identity_type')=="Driving License"
                                                ? 'selected' : ''); ?>> <?php echo e(trans('labels.driving_license')); ?> </option>
                                            <option value="NID" <?php echo e(old('identity_type')=="NID" ? 'selected' : ''); ?>> <?php echo e(trans('labels.nid')); ?> </option>
                                            <option value="Restaurant Id" <?php echo e(old('identity_type')=="Restaurant Id"
                                                ? 'selected' : ''); ?>> <?php echo e(trans('labels.restaurant_id')); ?> </option>
                                            <option value="Other" <?php echo e(old('identity_type')=="Other" ? 'selected' : ''); ?>>
                                                <?php echo e(trans('labels.other')); ?> </option>
                                        </select>
                                        <?php $__errorArgs = ['identity_type'];
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
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.identity_number')); ?> <span
                                                class="text-danger">*</span> </label>
                                        <input type="tel" class="form-control" name="identity_number"
                                            value="<?php echo e(old('identity_number')); ?>" id="identity_number"
                                            placeholder="<?php echo e(trans('labels.identity_number')); ?>">
                                        <?php $__errorArgs = ['identity_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for=""><?php echo e(trans('labels.identity_image')); ?> (420 x 525) <span
                                                class="text-danger">*</span> </label>
                                        <input type="file" class="form-control" name="image" value="<?php echo e(old('image')); ?>"
                                            id="image">
                                        <?php $__errorArgs = ['image'];
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
                                <a href="<?php echo e(URL::to('admin/driver')); ?>"
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
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/driver/add.blade.php ENDPATH**/ ?>