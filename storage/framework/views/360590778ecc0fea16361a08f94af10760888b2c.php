<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.rating')); ?></th>
            <th><?php echo e(trans('labels.review')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getreview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviews): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><i class="fa fa-star text-warning"></i> <?php echo e(number_format($reviews->ratting,1)); ?> </td>
                <td><small><?php echo e($reviews->comment); ?></small></td>
                <td>
                    <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="DeleteData('<?php echo e($reviews->id); ?>','<?php echo e(URL::to('admin/reviews/destroy')); ?>')" <?php endif; ?>><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/reviews/table.blade.php ENDPATH**/ ?>