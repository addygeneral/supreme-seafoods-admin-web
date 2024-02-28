<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <form action="<?php echo e(URL::to('admin/payment/update')); ?>" method="POST" class="payments" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="accordion accordion-flush" id="accordionExample">
                                <?php
                                    $i = 1;
                                ?>
                                <?php $__currentLoopData = $getpayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pmdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $transaction_type = $pmdata->id;
                                        $paymentname = $pmdata->payment_name;
                                        if ($transaction_type == 1) {
                                            $image_tag_name = 'cod_image';
                                        } elseif ($transaction_type == 2) {
                                            $image_tag_name = 'wallet_image';
                                        } elseif ($transaction_type == 3) {
                                            $image_tag_name = 'razorpay_image';
                                        } elseif ($transaction_type == 4) {
                                            $image_tag_name = 'stripe_image';
                                        } elseif ($transaction_type == 5) {
                                            $image_tag_name = 'flutterwave_image';
                                        } elseif ($transaction_type == 6) {
                                            $image_tag_name = 'paystack_image';
                                        } elseif ($transaction_type == 7) {
                                            $image_tag_name = 'mercadopago_image';
                                        } elseif ($transaction_type == 8) {
                                            $image_tag_name = 'myfatoorah_image';
                                        } elseif ($transaction_type == 9) {
                                            $image_tag_name = 'paypal_image';
                                        }elseif ($transaction_type == 10) {
                                            $image_tag_name = 'toyyibpay_image';
                                        }else {
                                            $image_tag_name = '';
                                        }
                                    ?>
                                    <input type="hidden" name="transaction_type[]" value="<?php echo e($transaction_type); ?>">
                                    <div class="accordion-item card rounded border mb-3">
                                        <h2 class="accordion-header" id="heading<?php echo e($transaction_type); ?>">
                                            <button class="accordion-button rounded collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#targetto-<?php echo e($i); ?>-<?php echo e($transaction_type); ?>"
                                                aria-expanded="false"
                                                aria-controls="targetto-<?php echo e($i); ?>-<?php echo e($transaction_type); ?>">
                                                <b><?php echo e($paymentname); ?></b>
                                            </button>
                                        </h2>
                                        <div id="targetto-<?php echo e($i); ?>-<?php echo e($transaction_type); ?>"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="heading<?php echo e($transaction_type); ?>"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <?php if(in_array($transaction_type, [3, 4, 5, 6,7,8,9,10])): ?>
                                                        <div class="col-md-6">
                                                            <p class="form-label"><?php echo e(trans('labels.environment')); ?></p>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="environment[<?php echo e($transaction_type); ?>]" id="<?php echo e($transaction_type); ?>_<?php echo e($key); ?>_environment" value="1" <?php echo e($pmdata->environment == 1 ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="<?php echo e($transaction_type); ?>_<?php echo e($key); ?>_environment"> <?php echo e(trans('labels.sandbox')); ?> </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="environment[<?php echo e($transaction_type); ?>]" id="<?php echo e($transaction_type); ?>_<?php echo e($i); ?>_environment" value="2" <?php echo e($pmdata->environment == 2 ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="<?php echo e($transaction_type); ?>_<?php echo e($i); ?>_environment"> <?php echo e(trans('labels.production')); ?> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex justify-content-end align-items-center"> 
                                                            <input id="checkbox-switch-<?php echo e($transaction_type); ?>" type="checkbox" class="checkbox-switch" name="is_available[<?php echo e($transaction_type); ?>]" value="1" <?php echo e($pmdata->is_available == 1 ? 'checked' : ''); ?>>
                                                            <label for="checkbox-switch-<?php echo e($transaction_type); ?>" class="switch"> 
                                                                <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                                                <span class="switch__left ps-2"><?php echo e(trans('labels.off')); ?></span>
                                                                <span class="switch__right pe-2"><?php echo e(trans('labels.on')); ?></span>
                                                            </label>
                                                        </div>
                                                        <?php if($transaction_type == 7 || $transaction_type == 8): ?>
                                                        <div class="col-md-12">
                                                        <input type="hidden"  id="<?php echo e($transaction_type); ?>_publickey"  class="form-control" name="public_key[<?php echo e($transaction_type); ?>]" placeholder="<?php echo e(trans('labels.public_key')); ?>" value="<?php echo e($pmdata->public_key); ?>">
                                                        <?php elseif($transaction_type == 9): ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="<?php echo e($transaction_type); ?>_publickey" class="form-label"> <?php echo e(trans('labels.client_id')); ?> </label>
                                                                <input type="text" required id="<?php echo e($transaction_type); ?>_publickey"  class="form-control" name="public_key[<?php echo e($transaction_type); ?>]" placeholder="<?php echo e(trans('labels.client_id')); ?>" value="<?php echo e($pmdata->public_key); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">   
                                                        <?php else: ?>    
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="<?php echo e($transaction_type); ?>_publickey" class="form-label"> <?php echo e(trans('labels.public_key')); ?> </label>
                                                                <input type="text" required id="<?php echo e($transaction_type); ?>_publickey"  class="form-control" name="public_key[<?php echo e($transaction_type); ?>]" placeholder="<?php echo e(trans('labels.public_key')); ?>" value="<?php echo e($pmdata->public_key); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <?php endif; ?>    
                                                            <div class="form-group">
                                                                <label for="<?php echo e($transaction_type); ?>_secretkey" class="form-label"> <?php echo e(trans('labels.secret_key')); ?></label>
                                                                <input type="text" required id="<?php echo e($transaction_type); ?>_secretkey"  class="form-control" name="secret_key[<?php echo e($transaction_type); ?>]" placeholder="<?php echo e(trans('labels.secret_key')); ?>" value="<?php echo e($pmdata->secret_key); ?>">
                                                            </div>
                                                        </div>
                                                        <?php if($transaction_type == 5): ?>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="encryption_key" class="form-label"><?php echo e(trans('labels.encryption_key')); ?> </label>
                                                                    <input type="text" required id="encryptionkey" class="form-control"  name="encryption_key" placeholder="<?php echo e(trans('labels.encryption_key')); ?>" value="<?php echo e($pmdata->encryption_key); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="image" class="form-label"> <?php echo e(trans('labels.image')); ?> </label>
                                                                <input type="file" class="form-control" name="<?php echo e($image_tag_name); ?>"> 
                                                                <img src="<?php echo e(Helper::image_path($pmdata->image)); ?>" alt="" class="img-fluid rounded hw-50 mt-1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="<?php echo e($transaction_type); ?>currency" class="form-label"> <?php echo e(trans('labels.currency')); ?> </label>
                                                                <input type="text" required id="<?php echo e($transaction_type); ?>currency"  class="form-control" name="currency[<?php echo e($transaction_type); ?>]" placeholder="<?php echo e(trans('labels.currency')); ?>" value="<?php echo e($pmdata->currency); ?>">
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="image" class="form-label"> <?php echo e(trans('labels.image')); ?> </label>
                                                                <input type="file" class="form-control" name="<?php echo e($image_tag_name); ?>"> 
                                                                <img src="<?php echo e(Helper::image_path($pmdata->image)); ?>" alt="" class="img-fluid rounded hw-50 mt-1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 d-flex justify-content-end align-items-center"> 
                                                            <input id="checkbox-switch-<?php echo e($transaction_type); ?>" type="checkbox" class="checkbox-switch" name="is_available[<?php echo e($transaction_type); ?>]" value="1" <?php echo e($pmdata->is_available == 1 ? 'checked' : ''); ?>>
                                                            <label for="checkbox-switch-<?php echo e($transaction_type); ?>" class="switch"> 
                                                                <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                                                                <span class="switch__left ps-2"><?php echo e(trans('labels.off')); ?></span>
                                                                <span class="switch__right pe-2"><?php echo e(trans('labels.on')); ?></span>
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group text-end">
                                <button class="btn btn-primary" <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/payment.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/payment/payment.blade.php ENDPATH**/ ?>