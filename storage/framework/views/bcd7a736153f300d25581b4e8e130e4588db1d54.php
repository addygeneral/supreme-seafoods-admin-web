<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.name')); ?></th>
            <th><?php echo e(trans('labels.coordinates')); ?></th>
            <th><?php echo e(trans('labels.delivery_charge')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $zonedata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr id="dataid<?php echo e($zone->id); ?>">
            <td><?php echo $i++; ?></td>
            <td><?php echo e($zone->name); ?></td>
            <td class="w-50"><?php echo e($zone->coordinates); ?></td>
            <td><?php echo e($zone->delivery_charge); ?></td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="<?php echo e(URL::to('admin/zone/'.$zone->id)); ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="Delete('<?php echo e($zone->id); ?>','<?php echo e(URL::to('admin/zone/delete')); ?>')" <?php endif; ?>><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/zone/zonetable.blade.php ENDPATH**/ ?>