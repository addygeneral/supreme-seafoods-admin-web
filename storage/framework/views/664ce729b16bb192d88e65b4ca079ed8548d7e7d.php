<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.offer_name')); ?></th>
            <th><?php echo e(trans('labels.offer_code')); ?></th>
            <th><?php echo e(trans('labels.discount')); ?></th>
            <th><?php echo e(trans('labels.status')); ?> </th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getpromocode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promocode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="dataid<?php echo e($promocode->id); ?>">
                <td><?php echo $i++; ?></td>
                <td><?php echo e($promocode->offer_name); ?></td>
                <td><?php echo e($promocode->offer_code); ?></td>
                <td><?php echo e($promocode->offer_type == 1 ? Helper::currency_format($promocode->offer_amount) : $promocode->offer_amount . '%'); ?>

                </td>
                <td>
                    <?php if($promocode->is_available == 1): ?>
                        <a class="btn btn-sm btn-outline-success"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($promocode->id); ?>','2','<?php echo e(URL::to('admin/promocode/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    <?php else: ?>
                        <a class="btn btn-sm btn-outline-danger"
                            <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($promocode->id); ?>','1','<?php echo e(URL::to('admin/promocode/status')); ?>')" <?php endif; ?>><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-info" href="<?php echo e(URL::to('admin/promocode-' . $promocode->id)); ?>"><i
                            class="fa-solid fa-pen-to-square"></i></a>
                    <a class="btn btn-sm btn-outline-danger d-none"
                        <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="deletedata('<?php echo e(URL::to('admin/promocode/delete-' . $promocode->id)); ?>')" <?php endif; ?>><i
                            class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/promocode/promocodetable.blade.php ENDPATH**/ ?>