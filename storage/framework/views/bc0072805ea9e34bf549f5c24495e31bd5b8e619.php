<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.image')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.item')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getbanner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($banner->section == $section): ?>
                <tr id="dataid<?php echo e($banner->id); ?>">
                    <td><?php echo $i++; ?></td>
                    <td><img src='<?php echo e(Helper::image_path($banner->image)); ?>' class='img-fluid rounded hw-50'></td>
                    <td>
                        <?php if($banner->type == '1'): ?>
                            <?php echo e(@$banner['category_info']->category_name); ?>

                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($banner->type == '2'): ?>
                            <?php echo e(@$banner['item_info']->item_name); ?>

                        <?php else: ?>
                            --
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($banner->is_available == 1): ?>
                            <a class="btn btn-sm btn-outline-success"
                                <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($banner->id); ?>','2','<?php echo e(URL::to('admin/banner/status')); ?>')" <?php endif; ?>><i
                                    class="fa-sharp fa-solid fa-check"></i></a>
                        <?php else: ?>
                            <a class="btn btn-sm btn-outline-danger"
                                <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($banner->id); ?>','1','<?php echo e(URL::to('admin/banner/status')); ?>')" <?php endif; ?>><i
                                    class="fa-sharp fa-solid fa-xmark"></i></a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-info"
                            href="<?php echo e(URL::to('admin/bannersection-' . $banner->section . '-' . $banner->id)); ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)"
                            <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="DeleteData('<?php echo e($banner->id); ?>','<?php echo e(URL::to('admin/banner/destroy')); ?>')" <?php endif; ?>><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/banner/bannertable.blade.php ENDPATH**/ ?>