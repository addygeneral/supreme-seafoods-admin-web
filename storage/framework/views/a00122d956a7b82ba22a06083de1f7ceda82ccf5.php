<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(@Helper::appdata()->title); ?> | <?php echo e(trans('labels.admin_title')); ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(Helper::image_path(@Helper::appdata()->favicon)); ?>">
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/bootstrap/bootstrap.min.css')); ?>"><!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/fontawesome/all.min.css')); ?>"><!-- FontAwesome CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/toastr/toastr.min.css')); ?>"><!-- Toastr CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/sweetalert/sweetalert2.min.css')); ?>"><!-- Sweetalert CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/style.css')); ?>"><!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/responsive.css')); ?>"><!-- Responsive CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/datatables/dataTables.bootstrap5.min.css')); ?>"><!-- dataTables css -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/datatables/dataTables.bootstrap5.min.css')); ?>"><!-- dataTables css -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/datatables/buttons.dataTables.min.css')); ?>"><!-- dataTables css -->
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('admin.theme.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main>
        <div class="wrapper">
            <?php echo $__env->make('admin.theme.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="content-wrapper">
                <?php echo $__env->make('admin.theme.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="main-content">
                    <div class="page-content">
                        <?php if(Helper::check_alert() == 0): ?>
                            <div class="alert alert-danger text-center">
                                <a href="<?php echo e(URL::to('admin/settings')); ?>" class="text-dark"> <i class="fa fa-cog"></i> <?php echo e(trans('messages.settings_note')); ?></a>
                            </div>
                        <?php endif; ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </div>
            <!-- Modal Change Password-->
            <div class="modal fade text-left" id="editprofilemodal" tabindex="-1" role="dialog" aria-labelledby="RditProduct" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title text-text-bold-600" id="RditProduct"><?php echo e(trans('labels.edit_profile')); ?></label>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?php echo e(URL::to('admin/edit-profile')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?php echo e(trans('labels.name')); ?> </label>
                                        <div class="form-group">
                                            <input type="text" placeholder="<?php echo e(trans('labels.name')); ?>"
                                                class="form-control" name="name" value="<?php echo e(Auth::user()->name); ?>" required>
                                            <?php $__errorArgs = ['name'];
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
                                        <label><?php echo e(trans('labels.email')); ?> </label>
                                        <div class="form-group">
                                            <input type="email" placeholder="<?php echo e(trans('labels.email')); ?>"
                                                class="form-control" name="email" value="<?php echo e(Auth::user()->email); ?>" required>
                                            <?php $__errorArgs = ['email'];
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
                                        <label><?php echo e(trans('labels.mobile')); ?> </label>
                                        <div class="form-group">
                                            <input type="text" placeholder="<?php echo e(trans('labels.mobile')); ?>"
                                                class="form-control" name="mobile" id="mobile" value="<?php echo e(Auth::user()->mobile); ?>" required>
                                            <?php $__errorArgs = ['mobile'];
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
                                    <div class="col-md-6">
                                        <label><?php echo e(trans('labels.image')); ?> </label>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="profile" accept=".jpg,.jpeg,.png">
                                            <?php $__errorArgs = ['profile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <br> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <img src="<?php echo e(Helper::image_path(Auth::user()->profile_image)); ?>" class="img-fluid rounded user-profile-image mt-1" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                                <input class="btn btn-primary" <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?>
                                    value="<?php echo e(trans('labels.edit')); ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Change Password-->
            <div class="modal fade text-left" id="changepasswordmodal" tabindex="-1" role="dialog" aria-labelledby="RditProduct" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title text-text-bold-600" id="RditProduct"><?php echo e(trans('labels.change_password')); ?></label>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?php echo e(URL::to('admin/change-password')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><?php echo e(trans('labels.old_password')); ?> </label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="<?php echo e(trans('labels.old_password')); ?>" value=" " required>
                                            <?php $__errorArgs = ['oldpassword'];
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
                                        <label><?php echo e(trans('labels.new_password')); ?> </label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="<?php echo e(trans('labels.new_password')); ?>" required>
                                            <?php $__errorArgs = ['newpassword'];
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
                                        <label><?php echo e(trans('labels.confirm_password')); ?> </label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="<?php echo e(trans('labels.confirm_password')); ?>" required>
                                            <?php $__errorArgs = ['confirmpassword'];
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
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                                <input class="btn btn-primary" <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" <?php endif; ?> value="<?php echo e(trans('labels.edit')); ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Modal: order-modal-->
            <div class="modal fade" id="order-modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-notify modal-info" role="document">
                    <div class="modal-content text-center">
                        <div class="modal-header d-flex justify-content-center">
                            <p class="heading"><?php echo e(trans('messages.be_up_to_date')); ?></p>
                        </div>
                        <div class="modal-body"><i class="fa fa-bell fa-4x animated rotateIn mb-4"></i>
                            <p><?php echo e(trans('messages.new_order_arrive')); ?></p>
                        </div>
                        <div class="modal-footer flex-center">
                            <a role="button" class="btn btn-outline-secondary-modal waves-effect"
                                onClick="window.location.reload();"
                                data-bs-dismiss="modal"><?php echo e(trans('labels.okay')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--Modal: modalPush-->
            <!-- ASSIGN-DRIVER-MODAL-START -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="post" id="assign">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="driverurl" id="driverurl"
                                value="<?php echo e(URL::to('admin/orders/assign-driver')); ?>">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" id="order_id" name="order_id" readonly>
                                <div class="form-group">
                                    <label for="category_id"
                                        class="col-form-label"><?php echo e(trans('labels.order_number')); ?></label>
                                    <input type="text" class="form-control" id="order_number" readonly="">
                                    <span class="id_error text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="category_id"
                                        class="col-form-label"><?php echo e(trans('messages.select_driver')); ?>

                                    </label>
                                    <select class="form-control" name="driver_id" id="driver_id"
                                        required="required">
                                        <option value="" selected><?php echo e(trans('messages.select_driver')); ?>

                                        </option>
                                        <?php if(is_array(@$getdriver) || is_object(@$getdriver)): ?>
                                            <?php $__currentLoopData = @$getdriver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($driver->id); ?>">
                                                    <?php echo e($driver->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <span class="driver_error text-danger"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                    data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                                <button type="button" class="btn btn-primary"
                                    onclick="assigndriver()"><?php echo e(trans('labels.save')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ASSIGN-DRIVER-MODAL-END -->
            <footer class="py-3 text-center bg-white fixed-bottom border-top">
                Copyrights @ 2021-22 &amp; <?php echo e(trans('labels.designed_developed_by')); ?> <a
                    href="https://urhitech.com/" target="_blank"><?php echo e(trans('labels.gravity_infotech')); ?></a>
            </footer>
        </div>
    </main>
    <?php echo $__env->make('admin.theme.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script type="text/javascript">
        let are_you_sure = "<?php echo e(trans('messages.are_you_sure')); ?>";
        let yes = "<?php echo e(trans('messages.yes')); ?>";
        let no = "<?php echo e(trans('messages.no')); ?>";
        let wrong = "<?php echo e(trans('messages.wrong')); ?>";
        let cannot_delete = "<?php echo e(trans('messages.cannot_delete')); ?>";
        let last_image = "<?php echo e(trans('messages.last_image')); ?>";
        let record_safe = "<?php echo e(trans('messages.record_safe')); ?>";
        let select = "<?php echo e(trans('labels.select')); ?>";
        let variation = "<?php echo e(trans('labels.variation')); ?>";
        let enter_variation = "<?php echo e(trans('labels.variation')); ?>";
        let product_price = "<?php echo e(trans('labels.product_price')); ?>";
        let enter_product_price = "<?php echo e(trans('labels.product_price')); ?>";
        let sale_price = "<?php echo e(trans('labels.sale_price')); ?>";
        let enter_sale_price = "<?php echo e(trans('labels.sale_price')); ?>";
        function currency_format(price) {
            if ("<?php echo e(@Helper::appdata()->currency_position); ?>" == 1) {
                return "<?php echo e(@Helper::appdata()->currency); ?>" + parseFloat(price).toFixed(2);
            } else {
                return parseFloat(price).toFixed(2) + "<?php echo e(@Helper::appdata()->currency); ?>";
            }
        }
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        <?php if(Session::has('success')): ?>
            toastr.success("<?php echo e(session('success')); ?>");
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>
        // New Notification 
        var noticount = 0;
        (function noti() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(url('admin/getorder')); ?>",
                method: 'GET', //Get method,
                dataType: "json",
                success: function(response) {
                    noticount = localStorage.getItem("count");
                    if (response.count > 9) {
                        $('#notificationcount').text(response.count + "+");
                    } else {
                        $('#notificationcount').text(response.count);
                    }
                    if (response.count != 0) {
                        if (noticount != response.count) {
                            localStorage.setItem("count", response.count);
                            jQuery("#order-modal").modal('show');
                            var audio = new Audio("<?php echo e(url(env('ASSETSPATHURL'))); ?>/admin-assets/notification/"+response.noti);
                            audio.play();
                        }
                    } else {
                        localStorage.setItem("count", response.count);
                    }
                    setTimeout(noti, 5000);
                }
            });
        })();
    </script>
     <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/common.js')); ?>"></script><!-- Common JS -->
    <?php echo $__env->yieldContent('script'); ?>
</body>
</html><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/theme/default.blade.php ENDPATH**/ ?>