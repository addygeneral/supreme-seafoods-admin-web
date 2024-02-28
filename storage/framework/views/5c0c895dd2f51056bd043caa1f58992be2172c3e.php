<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="card border-0">
            <div class="card-body">
                <div class="table-responsive" id="table-display">
                    <table class="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo e(trans('labels.booking_number')); ?></th>
                                <th><?php echo e(trans('labels.user_info')); ?></th>
                                <th><?php echo e(trans('labels.date_time')); ?></th>
                                <th><?php echo e(trans('labels.guests')); ?></th>
                                <th><?php echo e(trans('labels.reservation_type')); ?></th>
                                <th><?php echo e(trans('labels.message')); ?></th>
                                <th><?php echo e(trans('labels.table_number')); ?></th>
                                <th><?php echo e(trans('labels.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            <?php $__currentLoopData = $getbookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo e($booking->booking_number); ?></td>
                                <td><?php echo e($booking->name); ?> <br> <?php echo e($booking->email); ?> <br> <?php echo e($booking->mobile); ?></td>
                                <td><?php echo e($booking->date); ?> <br> <?php echo e($booking->time); ?> </td>
                                <td><?php echo e($booking->guests); ?></td>
                                <td><?php echo e($booking->reservation_type); ?> </td>
                                <td><?php echo e(Str::limit($booking->special_request,100)); ?></td>
                                <td><?php echo e($booking->status == 2 ? $booking->table_number : '--'); ?></td>
                                <td>
                                    <?php if($booking->status == 1): ?>
                                        <a class="btn btn-sm btn-outline-success open-table-modal" data-bs-toggle="modal" data-id="<?php echo e($booking->id); ?>" data-booking-number="<?php echo e($booking->booking_number); ?>" data-bs-target="#tablemodal"><i class="fa-sharp fa-solid fa-check"></i></a>
                                        <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="StatusUpdate('<?php echo e($booking->id); ?>','3','<?php echo e(URL::to('/admin/bookings/status')); ?>')" <?php endif; ?>><i class="fa-sharp fa-solid fa-xmark"></i></a>
                                    <?php elseif($booking->status == 2): ?>
                                        <span class="text-success"><?php echo e(trans('labels.accepted')); ?></span>
                                    <?php elseif($booking->status == 3): ?>
                                        <span class="text-danger"><?php echo e(trans('labels.rejected')); ?></span>
                                    <?php else: ?>
                                        --
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal-add-table-number -->
<div id="tablemodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title fw-bold"><?php echo e(trans('labels.accept')); ?> <?php echo e(trans('labels.booking')); ?></label>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bookingid" class="col-form-label"><?php echo e(trans('labels.booking_number')); ?></label>
                        <input type="hidden" class="form-control" id="bookingid" name="bookingid" readonly="">
                        <input type="text" class="form-control" id="booking_number" name="booking_number" readonly="" placeholder="<?php echo e(trans('labels.booking_number')); ?>">
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-form-label"><?php echo e(trans('labels.table_number')); ?></label>
                        <input type="tel" class="form-control" name="table_number" placeholder="<?php echo e(trans('labels.table_number')); ?>" id="table_number" required="required">
                        <span class="table_error text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><?php echo e(trans('labels.close')); ?></button>
                    <button type="button" class="btn btn-primary" <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="set_table_number('2','<?php echo e(URL::to('/admin/bookings/status')); ?>')" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/bookings.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/bookings/bookings.blade.php ENDPATH**/ ?>