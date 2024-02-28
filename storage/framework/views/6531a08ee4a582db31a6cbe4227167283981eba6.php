<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.name')); ?></th>
            <th><?php echo e(trans('labels.price')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1 ?>
        <?php $__currentLoopData = $getaddons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addons): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="dataid<?php echo e($addons->id); ?>">
                <td><?php echo $i++ ?></td>
                <td><?php echo e($addons->name); ?></td>
                <td><?php echo e(Helper::currency_format($addons->price)); ?></td>
                <td>
                    <?php if($addons->is_available == 1): ?>
                        <a class="btn btn-sm btn-outline-success"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($addons->id); ?>','2','<?php echo e(URL::to('admin/addons/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-outline-danger"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($addons->id); ?>','1','<?php echo e(URL::to('admin/addons/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-info" href="<?php echo e(URL::to('admin/addons-' . $addons->id)); ?>"><i
                            class="fa-solid fa-pen-to-square"></i></a>
                    <a class="btn btn-sm btn-outline-danger"
                        <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="Delete('<?php echo e($addons->id); ?>','<?php echo e(URL::to('admin/addons/delete')); ?>')" <?php endif; ?>><i
                            class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/addons/addonstable.blade.php ENDPATH**/ ?>