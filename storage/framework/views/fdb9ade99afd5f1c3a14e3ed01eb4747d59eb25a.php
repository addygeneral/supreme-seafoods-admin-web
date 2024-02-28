<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo e(@Helper::appdata()->title); ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(Helper::image_path(@Helper::appdata()->favicon)); ?>">
    <!-- Favicon icon -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/bootstrap/bootstrap.min.css')); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/fontawesome/all.min.css')); ?>">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/toastr/toastr.min.css')); ?>">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/style.css')); ?>"><!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/css/responsive.css')); ?>"><!-- Responsive CSS -->
</head>

<body>
    <?php echo $__env->make('admin.theme.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="auth-main-content d-flex h-100 justify-content-center align-items-center">
        <div class="row justify-content-center align-items-center g-0 w-100">
            <div class="col-xl-4 col-lg-6 col-md-8 col-auto px-md-5 px-2">
                <div class="card box-shadow overflow-hidden border-0">
                    <div class="bg-primary-light">
                        <div class="row">
                            <div class="col-7 d-flex align-items-center"> 
                                <div class="text-primary p-4">
                                    <h4><?php echo e(trans('labels.welcome_back')); ?></h4>
                                    <p><?php echo e(trans('labels.sign_to_continue')); ?></p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="<?php echo e(Helper::image_path('authformbgimage.png')); ?>" class="img-fluid"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form class="my-3" method="POST" action="<?php echo e(URL::to('admin/check-login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <input id="email" type="email"
                                    class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                    required="" autocomplete="email" autofocus
                                    placeholder="<?php echo e(trans('labels.email')); ?>"
                                    <?php if(env('Environment') == 'sendbox'): ?> value="admin@gmail.com" readonly="" <?php endif; ?>>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"
                                        role="alert"><strong><?php echo e($message); ?></strong></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password"
                                    required autocomplete="current-password"
                                    placeholder="<?php echo e(trans('labels.password')); ?>"
                                    <?php if(env('Environment') == 'sendbox'): ?> value="123456" readonly="" <?php endif; ?>>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"
                                        role="alert"><strong><?php echo e($message); ?></strong></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button class="btn btn-primary w-100 my-3"
                                type="submit"><?php echo e(trans('labels.signin')); ?></button>
                        </form>
                        <?php if(env('Environment') == 'sendbox'): ?>
                            <div class="form-group mt-3">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Admin<br>admin@gmail.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info"
                                                    onclick="AdminFill()"><?php echo e(trans('labels.copy')); ?></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Employee<br>employee@yopmail.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info"
                                                    onclick="VendorFill()"><?php echo e(trans('labels.copy')); ?></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3 text-center">
                            <a href="<?php echo e(URL::to('admin/forgot-password')); ?>" class="text-muted fs-8 fw-500">
                                <i
                                    class="fa-solid fa-lock-keyhole mx-2 fs-7"></i><?php echo e(trans('labels.forgot_password_q')); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="circles-backgound-area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/jquery/jquery.min.js')); ?>"></script><!-- jQuery JS -->
    <script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/bootstrap/bootstrap.bundle.min.js')); ?>"></script><!-- Bootstrap JS -->
    <script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/toastr/toastr.min.js')); ?>"></script><!-- Toastr JS -->
    <script>
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
        $(window).on("load", function() {
            "use strict";
            $('#preloader').fadeOut('slow')
        });

        function AdminFill() {
            $('#email').val('admin@gmail.com');
            $('#password').val('123456');
        }

        function VendorFill() {
            $('#email').val('employee@yopmail.com');
            $('#password').val('123456');
        }
    </script>
</body>

</html>
<?php /**PATH /opt/lampp/htdocs/s-admin-new/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>