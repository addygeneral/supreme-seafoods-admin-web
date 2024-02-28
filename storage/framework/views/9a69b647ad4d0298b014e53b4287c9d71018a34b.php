<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" id="table-display">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(trans('labels.name')); ?></th>
                                    <th><?php echo e(trans('labels.email')); ?></th>
                                    <th><?php echo e(trans('labels.message')); ?></th>
                                    <th><?php echo e(trans('labels.action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                <?php $__currentLoopData = $getcontact; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo e($contact->firstname); ?> <?php echo e($contact->lastname); ?></td>
                                    <td><?php echo e($contact->email); ?></td>
                                    <td><?php echo e($contact->message); ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-danger" <?php if(env('Environment')=='sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="DeleteData('<?php echo e($contact->id); ?>','<?php echo e(URL::to('admin/contact/destroy')); ?>')" <?php endif; ?>><i class="fa fa-trash"></i></a>
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
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        function DeleteData(id, deleteurl) {
            "use strict";
            swalWithBootstrapButtons.fire({
                icon: 'warning',
                title: are_you_sure,
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: yes,
                cancelButtonText: no,
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: deleteurl,
                            data: { id: id },
                            method: 'POST',
                            success: function (response) {
                                if (response == 1) {
                                    location.reload();
                                } else {
                                    swal_cancelled()
                                }
                            },
                            error: function (e) {
                                swal_cancelled()
                            }
                        });
                    });
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    result.dismiss === Swal.DismissReason.cancel
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sup4foodan/app.supremeseafoodandsuya.com/resources/views/admin/contact/contact.blade.php ENDPATH**/ ?>