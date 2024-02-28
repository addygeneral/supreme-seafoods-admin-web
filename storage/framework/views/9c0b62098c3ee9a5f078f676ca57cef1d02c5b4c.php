<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.title')); ?></th>
            <th><?php echo e(trans('labels.message')); ?></th>
            <th><?php echo e(trans('labels.category')); ?></th>
            <th><?php echo e(trans('labels.item')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php $__currentLoopData = $getnotification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo e($notification->title); ?></td>
            <td><?php echo e($notification->message); ?></td>
            <td><?php echo e($notification->cat_id == "" ? '--' : @$notification['category_info']->category_name); ?></td>
            <td><?php echo e($notification->item_id == "" ? '--' : @$notification['item_info']->item_name); ?>

        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /opt/lampp/htdocs/s-admin-new/resources/views/admin/notification/notificationtable.blade.php ENDPATH**/ ?>