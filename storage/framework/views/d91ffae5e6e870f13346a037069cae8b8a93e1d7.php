<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(trans('labels.order_number')); ?></th>
            <th><?php echo e(trans('labels.date')); ?></th>
            <th><?php echo e(trans('labels.user_info')); ?></th>
            <th><?php echo e(trans('labels.order_type')); ?></th>
            <th><?php echo e(trans('labels.grand_total')); ?></th>
            <th><?php echo e(trans('labels.status')); ?></th>
            <th><?php echo e(trans('labels.action')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
            foreach ($getorders as $orderdata) {
                ?>
        <tr id="dataid<?php echo e($orderdata->id); ?>">
            <td> <?php echo $i++; ?></td>
            <td><a href="<?php echo e(URL::to('admin/invoice/' . $orderdata->id)); ?>"><?php echo e($orderdata->order_number); ?></a></td>
            <td><?php echo e(Helper::date_format($orderdata->created_at)); ?></td>
            <td>
                  <?php if($orderdata->user_id == null): ?>
                    <?php echo e(@$orderdata->name); ?>

                  <?php else: ?>
                    <?php echo e(@$orderdata['user_info']->name); ?>

                  <?php endif; ?>
            </td>
            <td><?php echo e($orderdata->order_type == 1 ? trans('labels.delivery') : trans('labels.pickup')); ?></td>
            <td><?php echo e(Helper::currency_format($orderdata->grand_total)); ?>

                <br>
                <?php if($orderdata->status == 5): ?>
                    <small class="text-success"> <i class="fa-regular fa-clock"></i> <?php echo e(trans('labels.paid')); ?></small>
                <?php else: ?>
                    <small class="text-danger"> <i class="fa-regular fa-check"></i> <?php echo e(trans('labels.unpaid')); ?></small>
                <?php endif; ?>
            </td>
            <td>
                <?php if($orderdata->status == '1'): ?>
                    <small class="text-order-placed"><?php echo e(trans('labels.placed')); ?></small>
                <?php elseif($orderdata->status == '2'): ?>
                    <small class="text-order-preparing"><?php echo e(trans('labels.preparing')); ?></small>
                <?php elseif($orderdata->status == '3'): ?>
                    <small class="text-order-ready"><?php echo e(trans('labels.ready')); ?></small>
                <?php elseif($orderdata->status == '4'): ?>
                    <?php if($orderdata->order_type == 2): ?>
                        <small class="text-order-waitingpickup"><?php echo e(trans('labels.waiting_pickup')); ?></small>
                    <?php else: ?>
                        <small class="text-order-ontheway"><?php echo e(trans('labels.on_the_way')); ?></small>
                    <?php endif; ?>
                <?php elseif($orderdata->status == '5'): ?>
                    <small class="text-order-completed"><?php echo e(trans('labels.completed')); ?></small>
                <?php elseif($orderdata->status == '6' || $orderdata->status == '7'): ?>
                    <small class="text-order-cancelled"><?php echo e(trans('labels.cancelled')); ?></small>
                <?php else: ?>
                    --
                <?php endif; ?>
            </td>
            <td>
                <a class="btn btn-sm btn-light" title="<?php echo e(trans('labels.view')); ?>" href="<?php echo e(URL::to('admin/invoice/' . $orderdata->id)); ?>"><i class="fa-regular fa-eye"></i></a>
                <a class="btn btn-sm btn-light" title="<?php echo e(trans('labels.print')); ?>" href="<?php echo e(URL::to('admin/print/' . $orderdata->id)); ?>"><i class="fa-regular fa-print"></i></a>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php /**PATH /opt/lampp/htdocs/s-admin-new/resources/views/admin/orders/orderstable.blade.php ENDPATH**/ ?>