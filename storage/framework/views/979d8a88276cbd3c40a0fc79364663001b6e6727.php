<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.name')); ?></th>
            <th><?php echo e(trans('labels.email')); ?></th>
            <th><?php echo e(trans('labels.mobile')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getdriverlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td> <?php echo e($driver->name); ?> </td>
                <td> <?php echo e($driver->email); ?> </td>
                <td> <?php echo e($driver->mobile); ?> </td>
                <td>
                <?php if($driver->is_available == 1): ?>
                    <a class="btn btn-sm btn-outline-success" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($driver->id); ?>','2','<?php echo e(URL::to('admin/driver/status')); ?>')" <?php endif; ?>> <i class="fa-sharp fa-solid fa-check"></i></a>
                <?php else: ?>
                    <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($driver->id); ?>','1','<?php echo e(URL::to('admin/driver/status')); ?>')" <?php endif; ?>> <i class="fa-sharp fa-solid fa-xmark"></i></a>
                <?php endif; ?>
                </td>
                <td><a class="btn btn-sm btn-outline-info" href="<?php echo e(URL::to('admin/driver-'.$driver->id)); ?>"><i class="fa fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-dark" href="<?php echo e(URL::to('admin/driver/details-'.$driver->id)); ?>"><i class="fa-solid fa-eye"></i></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/driver/table.blade.php ENDPATH**/ ?>