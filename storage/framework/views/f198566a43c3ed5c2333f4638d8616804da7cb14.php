<header class="page-topbar">
    <div class="navbar-header">
        <button class="navbar-toggler d-lg-none d-md-block px-4" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarcollapse" aria-expanded="false" aria-controls="sidebarcollapse">
            <i class="fa-regular fa-bars fs-4"></i>
        </button>
        <div class="px-3 d-flex align-items-center">
            <?php if(Auth::user()->type == 1): ?>
            <?php if(Helper::check_restaurant_closed() == 1): ?>
                <?php
                    $tooltiptitle = trans('messages.online_note');
                ?>
                <input id="open-close-switch" type="checkbox" class="checkbox-switch" name="open-close" value="1" checked <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" disabled <?php else: ?> onclick="changeStatus(2,'<?php echo e(URL::to('admin/change-status')); ?>')" <?php endif; ?>>
            <?php else: ?>
                <?php
                    $tooltiptitle = trans('messages.offline_note');
                ?>
                <input id="open-close-switch" type="checkbox" class="checkbox-switch" name="open-close" value="" <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" disabled <?php else: ?> onclick="changeStatus(1,'<?php echo e(URL::to('admin/change-status')); ?>')" <?php endif; ?>>
            <?php endif; ?>
            <label for="open-close-switch" class="switch me-3" data-bs-toggle="tooltip" title="<?php echo e($tooltiptitle); ?>" >
                <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                <span class="switch__left ps-2"><?php echo e(trans('labels.off')); ?></span>
                <span class="switch__right pe-2"><?php echo e(trans('labels.on')); ?></span>
            </label>
            <?php endif; ?>
            <div class="dropwdown d-inline-block">
                <button class="btn header-item" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo e(Helper::image_path(Auth::user()->profile_image)); ?>">
                    <span class="d-none d-xxl-inline-block d-xl-inline-block ms-1"><?php echo e(Auth::user()->name); ?></span>
                    <i class="fa-regular fa-angle-down d-none d-xxl-inline-block d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu box-shadow">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editprofilemodal"><i class="fa-regular fa-user mx-2"></i><?php echo e(trans('labels.edit_profile')); ?> </a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#changepasswordmodal"><i class="fa-regular fa-key mx-2"></i><?php echo e(trans('labels.change_password')); ?> </a>
                    <a class="dropdown-item d-flex align-items-center" onclick="logout('<?php echo e(URL::to('/admin/logout')); ?>')" ><i class="fa-regular fa-arrow-right-from-bracket mx-2"></i><?php echo e(trans('labels.logout')); ?> </a>
                </div>
            </div>
        </div>
    </div>
</header><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/theme/header.blade.php ENDPATH**/ ?>