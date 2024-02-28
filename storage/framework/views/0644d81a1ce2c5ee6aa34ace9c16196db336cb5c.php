<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5 col-xl-4">
            
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="card-header text-center">
                        <h4 class="card-title mb-0">#<?php echo e($orderdata->order_number); ?></h4>
                    </div>
                    <div class="basic-list-group">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <?php echo e(trans('labels.order_type')); ?>

                                <span><?php echo e($orderdata->order_type == '1' ? trans('labels.delivery') : trans('labels.pickup')); ?></span>
                                <input type="hidden" name="order_type" id="order_type" value="<?php echo e($orderdata->order_type); ?>">
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <?php echo e(trans('labels.payment_type')); ?>

                                <span>
                                    <?php if($orderdata->transaction_type == 1): ?>
                                    <?php echo e(trans('labels.cash')); ?>

                                    <?php elseif($orderdata->transaction_type == 2): ?>
                                    <?php echo e(trans('labels.wallet')); ?>

                                    <?php elseif($orderdata->transaction_type == 3): ?>
                                    <?php echo e(trans('labels.razorpay')); ?>

                                    <?php elseif($orderdata->transaction_type == 4): ?>
                                    <?php echo e(trans('labels.stripe')); ?>

                                    <?php elseif($orderdata->transaction_type == 5): ?>
                                    <?php echo e(trans('labels.flutterwave')); ?>

                                    <?php elseif($orderdata->transaction_type == 6): ?>
                                    <?php echo e(trans('labels.paystack')); ?>

                                    <?php elseif($orderdata->transaction_type == 7): ?>
                                    <?php echo e(trans('labels.mercadopago')); ?>

                                    <?php elseif($orderdata->transaction_type == 8): ?>
                                    <?php echo e(trans('labels.myfatoorah')); ?>

                                    <?php elseif($orderdata->transaction_type == 9): ?>
                                    <?php echo e(trans('labels.paypal')); ?>

                                    <?php elseif($orderdata->transaction_type == 10): ?>
                                    <?php echo e(trans('labels.toyyibpay')); ?>

                                    <?php else: ?>
                                    --
                                    <?php endif; ?>
                                </span>
                            </li>
                            <?php if(!in_array($orderdata->transaction_type, [1, 2])): ?>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <?php echo e(trans('labels.transaction_id')); ?>

                                <span><?php echo e($orderdata->transaction_id); ?></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php if($orderdata->order_notes != ''): ?>
                    <h4><?php echo e(trans('labels.order_note')); ?></h4>
                    <p class="text-muted"><?php echo e($orderdata->order_notes); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="media d-flex align-items-center mb-2">
                        <?php if($check == 0): ?>
                        <img class="rounded hw-50" src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/images/profile/unknown.png')); ?>" alt="">
                        <?php else: ?>
                        <img class="rounded hw-50" src="<?php echo e($orderdata['user_info']->profile_image); ?>" alt="">
                        <?php endif; ?>
                        <h3 class="mb-0 mx-3">
                            <?php if($orderdata->user_id != null): ?>
                                <?php echo e(@$orderdata['user_info']->name); ?>

                            <?php else: ?> 
                                <?php echo e(@$orderdata->name); ?>

                            <?php endif; ?>
                        </h3>
                    </div>
                    <div class="basic-list-group">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-phone"></i></h5>
                                <?php if($orderdata->user_id != null): ?>
                                    <?php echo e(@$orderdata['user_info']->mobile); ?>

                                <?php else: ?>
                                    <?php echo e(@$orderdata->mobile); ?>

                                <?php endif; ?>    
                            </li>
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-envelope"></i></h5>
                                <?php if($orderdata->user_id != null): ?>
                                    <?php echo e(@$orderdata['user_info']->email); ?>

                                <?php else: ?>    
                                    <?php echo e(@$orderdata->email); ?>

                                <?php endif; ?> 
                            </li>
                            <?php if($orderdata->order_type == 1): ?>
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-map-marker"></i></h5>
                                <?php echo e($orderdata->address); ?>

                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-xl-8">
            <div class="row">
                <div class="col-md-12 my-2 d-flex justify-content-end">
                    <a href="<?php echo e(URL::to('admin/print/' . $orderdata->id)); ?>" class="btn btn-info mx-1">
                        <i class="fa fa-pdf" aria-hidden="true"></i> <?php echo e(trans('labels.print')); ?>

                    </a>
                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown"><?php echo e(trans('labels.action')); ?></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if($orderdata->order_from == 'pos'): ?>
                        <a class="dropdown-item w-auto <?php if($orderdata->status == '2'): ?> fw-600 <?php endif; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(trans('labels.complete')); ?>" onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','5','<?php echo e(URL::to('admin/orders/update')); ?>')">
                            <?php echo e(trans('labels.complete')); ?> </a>
                        <a class="dropdown-item w-auto" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(trans('labels.reject')); ?>" onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','6','<?php echo e(URL::to('admin/orders/update')); ?>')">
                            <?php echo e(trans('labels.reject')); ?> </a>
                        <?php else: ?>
                        <a class="dropdown-item w-auto <?php if($orderdata->status == '1'): ?> fw-600 <?php endif; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(trans('labels.accept')); ?>" onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','2','<?php echo e(URL::to('admin/orders/update')); ?>')"><?php echo e(trans('labels.accept')); ?></a>
                        <a class="dropdown-item w-auto <?php if($orderdata->status == '2'): ?> fw-600 <?php endif; ?>" onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','3','<?php echo e(URL::to('admin/orders/update')); ?>')"><?php echo e(trans('labels.ready')); ?></a>
                        <?php if($orderdata->order_type == '2'): ?>
                        <a class="dropdown-item w-auto <?php if($orderdata->status == '3'): ?> fw-600 <?php endif; ?>" onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','4','<?php echo e(URL::to('admin/orders/update')); ?>')"><?php echo e(trans('labels.ready_pickup')); ?></a>
                        <?php else: ?>
                        <a class="dropdown-item w-auto <?php if($orderdata->status == '3'): ?> fw-600 <?php endif; ?> open-AddBookDialog" data-bs-toggle="modal" data-id="<?php echo e($orderdata->id); ?>" data-number="<?php echo e($orderdata->order_number); ?>" data-bs-target="#myModal"><?php echo e(trans('labels.assign_to_driver')); ?></a>
                        <?php endif; ?>
                        <a class="dropdown-item w-auto <?php if($orderdata->status == '4'): ?> fw-600 <?php endif; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(trans('labels.complete')); ?>" onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','5','<?php echo e(URL::to('admin/orders/update')); ?>')"><?php echo e(trans('labels.complete')); ?></a>
                        <a class="dropdown-item w-auto" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(trans('labels.reject')); ?>" onclick="OrderStatusUpdate('<?php echo e($orderdata->id); ?>','6','<?php echo e(URL::to('admin/orders/update')); ?>')"><?php echo e(trans('labels.reject')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="progress-barrr">
                        <?php if(in_array($orderdata->status, [6, 7])): ?>
                        <div class="progress-step is-active">
                            <div class="step-count"><i class="fa fa-close"></i></div>
                            <div class="step-description">
                                <?php echo e($orderdata->status == '6' ? trans('labels.cancel_by_you') : trans('labels.cancel_by_user')); ?>

                            </div>
                        </div>
                        <?php else: ?>
                        <?php if(!in_array($orderdata->status, [1, 2, 3, 4, 5])): ?>
                        <div class="progress-step is-active">
                            <div class="step-count"><i class="fa fa-exclamation-triangle"></i></div>
                            <div class="step-description"><?php echo e(trans('messages.wrong')); ?></div>
                        </div>
                        <?php else: ?>
                        <div class="progress-step <?php if($orderdata->status == '1'): ?> is-active <?php endif; ?>">
                            <div class="step-count"><i class="fa fa-bell"></i></div>
                            <div class="step-description"><?php echo e(trans('labels.new_order')); ?></div>
                        </div>
                        <div class="progress-step <?php if($orderdata->status == '2'): ?> is-active <?php endif; ?>">
                            <div class="step-count"><i class="fa fa-tasks"></i></div>
                            <div class="step-description"><?php echo e(trans('labels.preparing')); ?></div>
                        </div>
                        <?php if($orderdata->order_from != 'pos'): ?>
                        <div class="progress-step <?php if($orderdata->status == '3'): ?> is-active <?php endif; ?>">
                            <div class="step-count"><i class="fa fa-thumbs-up"></i></div>
                            <div class="step-description"><?php echo e(trans('labels.ready')); ?></div>
                        </div>
                        <div class="progress-step <?php if($orderdata->status == '4'): ?> is-active <?php endif; ?>">
                            <?php if($orderdata->order_type == 2): ?>
                            <div class="step-count"><i class="fa fa-hourglass"></i></div>
                            <div class="step-description"><?php echo e(trans('labels.waiting_pickup')); ?></div>
                            <?php else: ?>
                            <div class="step-count"><i class="fa fa-user"></i></div>
                            <div class="step-description"><?php echo e(trans('labels.on_the_way')); ?>

                                <br><?php echo e($orderdata['driver_info'] != '' ? '[' . $orderdata['driver_info']->name . ']' : ''); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div class="progress-step <?php if($orderdata->status == '5'): ?> is-active <?php endif; ?>">
                            <div class="step-count"><i class="fa fa-check"></i></div>
                            <div class="step-description"><?php echo e(trans('labels.completed')); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('labels.image')); ?></th>
                                    <th><?php echo e(trans('labels.item')); ?></th>
                                    <th class="text-end"><?php echo e(trans('labels.unit_cost')); ?></th>
                                    <th class="text-end"><?php echo e(trans('labels.qty')); ?></th>
                                    <th class="text-end"><?php echo e(trans('labels.total')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = array();
                                foreach ($ordersdetails as $orders) {
                                    $total_price = ($orders['item_price'] + $orders['addons_total_price']) * $orders['qty'];
                                    $data[] = array("total_price" => $total_price,);
                                ?>
                                    <tr>
                                        <td><img src="<?php echo e(Helper::image_path($orders->item_image)); ?>" class="rounded hw-50" alt=""></td>
                                        <td>
                                            <img <?php if($orders['item_type']==1): ?> src="<?php echo e(Helper::image_path('veg.svg')); ?>" <?php else: ?> src="<?php echo e(Helper::image_path('nonveg.svg')); ?>" <?php endif; ?> class="item-type-img" alt="">
                                            <?php echo e($orders->item_name); ?> <?php if($orders->variation != ''): ?>
                                            [<?php echo e($orders->variation); ?>]
                                            <?php endif; ?> <br>
                                            <?php
                                            $addons_name = explode(',', $orders->addons_name);
                                            $addons_price = explode(',', $orders->addons_price);
                                            $addonstotal = $orders->addons_total_price;
                                            ?>
                                            <?php if($orders->addons_id != ''): ?>
                                            <?php $__currentLoopData = $addons_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <small class="text-muted"><?php echo e($addons_name[$key]); ?> :
                                                <span><?php echo e(Helper::currency_format($addons_price[$key])); ?></span></small><br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end"><?php echo e(Helper::currency_format($orders->item_price)); ?>

                                            <?php if($addonstotal != '0'): ?>
                                            <br><small class="text-muted">+
                                                <?php echo e(Helper::currency_format($addonstotal)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end"><?php echo e($orders->qty); ?></td>
                                        <td class="text-end"><?php echo e(Helper::currency_format($total_price)); ?></td>
                                    </tr>
                                <?php
                                }
                                $order_total = array_sum(array_column(@$data, 'total_price'));
                                ?>
                                <tr>
                                    <td class="text-end" colspan="4"> <strong><?php echo e(trans('labels.subtotal')); ?></strong> </td>
                                    <td class="text-end"><strong><?php echo e(Helper::currency_format($order_total)); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-end" colspan="4"> <strong><?php echo e(trans('labels.tax')); ?></strong>  </td>
                                    <td class="text-end"><strong><?php echo e(Helper::currency_format($orderdata->tax_amount)); ?></strong></td>
                                </tr>
                                <?php if($orderdata->discount_amount > 0): ?>
                                <tr>
                                    <td class="text-end" colspan="4"> <strong><?php echo e(trans('labels.discount')); ?></strong> <?php echo e($orderdata->offer_code != '' ? '(' . $orderdata->offer_code . ')' : ''); ?> </td>
                                    <td class="text-end"><strong><?php echo e(Helper::currency_format($orderdata->discount_amount)); ?></strong></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($orderdata->delivery_charge > 0): ?>
                                <tr>
                                    <td class="text-end" colspan="4"> <strong><?php echo e(trans('labels.delivery_charge')); ?></strong> </td>
                                    <td class="text-end"><strong><?php echo e(Helper::currency_format($orderdata->delivery_charge)); ?></strong></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-end" colspan="4">  <strong><?php echo e(trans('labels.grand_total')); ?></strong></td>
                                    <td class="text-end"><strong><?php echo e(Helper::currency_format($orderdata->grand_total)); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($orderdata->order_type == 1): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 mb-3">
                <div class="card-header">
                    <h4 class="card-title">Track order on map</h4>
                    <h6><code>On map Starting location is <strong>A</strong> and delivery location is
                            <strong>B</strong>. </code></h6>
                </div>
                <div id="map-layer" class="order-details-map"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/orders.js')); ?>"></script>
<script>
    var order_type = document.getElementById("order_type").value;
    function initMap() {
        if (order_type == 1) {
            var mapLayer = document.getElementById("map-layer");
            var centerCoordinates = new google.maps.LatLng("<?php echo e(@Helper::appdata()->lat); ?>",
                "<?php echo e(@Helper::appdata()->lang); ?>");
            var defaultOptions = {
                center: centerCoordinates,
                zoom: 17
            }
            var map = new google.maps.Map(mapLayer, defaultOptions);
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);
            var start = new google.maps.LatLng("<?php echo e(@Helper::appdata()->lat); ?>", "<?php echo e(@Helper::appdata()->lang); ?>");
            var end = new google.maps.LatLng("<?php echo e($orderdata->lat); ?>", "<?php echo e($orderdata->lang); ?>");
            drawPath(directionsService, directionsDisplay, start, end);
        }
    }
    function drawPath(directionsService, directionsDisplay, start, end) {
        directionsService.route({
            origin: start,
            destination: end,
            optimizeWaypoints: true,
            travelMode: "DRIVING"
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                toastr.error('Problem in showing direction due to ' + status);
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(@Helper::appdata()->map); ?>&callback=initMap">
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/s-admin-new/resources/views/admin/orders/invoice.blade.php ENDPATH**/ ?>