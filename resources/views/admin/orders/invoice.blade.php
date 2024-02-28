@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5 col-xl-4">
            {{-- order info --}}
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="card-header text-center">
                        <h4 class="card-title mb-0">#{{ $orderdata->order_number }}</h4>
                    </div>
                    <div class="basic-list-group">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                {{ trans('labels.order_type') }}
                                <span>{{ $orderdata->order_type == '1' ? trans('labels.delivery') : trans('labels.pickup') }}</span>
                                <input type="hidden" name="order_type" id="order_type" value="{{ $orderdata->order_type }}">
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                {{ trans('labels.payment_type') }}
                                <span>
                                    @if ($orderdata->transaction_type == 1)
                                    {{ trans('labels.cash') }}
                                    @elseif ($orderdata->transaction_type == 2)
                                    {{ trans('labels.wallet') }}
                                    @elseif ($orderdata->transaction_type == 3)
                                    {{ trans('labels.razorpay') }}
                                    @elseif ($orderdata->transaction_type == 4)
                                    {{ trans('labels.stripe') }}
                                    @elseif ($orderdata->transaction_type == 5)
                                    {{ trans('labels.flutterwave') }}
                                    @elseif ($orderdata->transaction_type == 6)
                                    {{ trans('labels.paystack') }}
                                    @elseif ($orderdata->transaction_type == 7)
                                    {{ trans('labels.mercadopago') }}
                                    @elseif ($orderdata->transaction_type == 8)
                                    {{ trans('labels.myfatoorah') }}
                                    @elseif ($orderdata->transaction_type == 9)
                                    {{ trans('labels.paypal') }}
                                    @elseif ($orderdata->transaction_type == 10)
                                    {{ trans('labels.toyyibpay') }}
                                    @else
                                    --
                                    @endif
                                </span>
                            </li>
                            @if (!in_array($orderdata->transaction_type, [1, 2]))
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                {{ trans('labels.transaction_id') }}
                                <span>{{ $orderdata->transaction_id }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @if ($orderdata->order_notes != '')
                    <h4>{{ trans('labels.order_note') }}</h4>
                    <p class="text-muted">{{ $orderdata->order_notes }}</p>
                    @endif
                </div>
            </div>
            {{-- user info --}}
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="media d-flex align-items-center mb-2">
                        @if($check == 0)
                        <img class="rounded hw-50" src="{{ url(env('ASSETSPATHURL').'admin-assets/images/profile/unknown.png')}}" alt="">
                        @else
                        <img class="rounded hw-50" src="{{ $orderdata['user_info']->profile_image }}" alt="">
                        @endif
                        <h3 class="mb-0 mx-3">
                            @if($orderdata->user_id != null)
                                {{ @$orderdata['user_info']->name }}
                            @else 
                                {{ @$orderdata->name }}
                            @endif
                        </h3>
                    </div>
                    <div class="basic-list-group">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-phone"></i></h5>
                                @if($orderdata->user_id != null)
                                    {{ @$orderdata['user_info']->mobile }}
                                @else
                                    {{ @$orderdata->mobile }}
                                @endif    
                            </li>
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-envelope"></i></h5>
                                @if($orderdata->user_id != null)
                                    {{ @$orderdata['user_info']->email }}
                                @else    
                                    {{ @$orderdata->email }}
                                @endif 
                            </li>
                            @if ($orderdata->order_type == 1)
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-map-marker"></i></h5>
                                {{ $orderdata->address }}
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-xl-8">
            <div class="row">
                <div class="col-md-12 my-2 d-flex justify-content-end">
                    <a href="{{ URL::to('admin/print/' . $orderdata->id) }}" class="btn btn-info mx-1">
                        <i class="fa fa-pdf" aria-hidden="true"></i> {{ trans('labels.print') }}
                    </a>
                    <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown">{{ trans('labels.action') }}</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if ($orderdata->order_from == 'pos')
                        <a class="dropdown-item w-auto @if ($orderdata->status == '2') fw-600 @endif" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('labels.complete') }}" onclick="OrderStatusUpdate('{{ $orderdata->id }}','5','{{ URL::to('admin/orders/update') }}')">
                            {{ trans('labels.complete') }} </a>
                        <a class="dropdown-item w-auto" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('labels.reject') }}" onclick="OrderStatusUpdate('{{ $orderdata->id }}','6','{{ URL::to('admin/orders/update') }}')">
                            {{ trans('labels.reject') }} </a>
                        @else
                        <a class="dropdown-item w-auto @if ($orderdata->status == '1') fw-600 @endif" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('labels.accept') }}" onclick="OrderStatusUpdate('{{ $orderdata->id }}','2','{{ URL::to('admin/orders/update') }}')">{{ trans('labels.accept') }}</a>
                        <a class="dropdown-item w-auto @if ($orderdata->status == '2') fw-600 @endif" onclick="OrderStatusUpdate('{{ $orderdata->id }}','3','{{ URL::to('admin/orders/update') }}')">{{ trans('labels.ready') }}</a>
                        @if ($orderdata->order_type == '2')
                        <a class="dropdown-item w-auto @if ($orderdata->status == '3') fw-600 @endif" onclick="OrderStatusUpdate('{{ $orderdata->id }}','4','{{ URL::to('admin/orders/update') }}')">{{ trans('labels.ready_pickup') }}</a>
                        @else
                        <a class="dropdown-item w-auto @if ($orderdata->status == '3') fw-600 @endif open-AddBookDialog" data-bs-toggle="modal" data-id="{{ $orderdata->id }}" data-number="{{ $orderdata->order_number }}" data-bs-target="#myModal">{{ trans('labels.assign_to_driver') }}</a>
                        @endif
                        <a class="dropdown-item w-auto @if ($orderdata->status == '4') fw-600 @endif" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('labels.complete') }}" onclick="OrderStatusUpdate('{{ $orderdata->id }}','5','{{ URL::to('admin/orders/update') }}')">{{ trans('labels.complete') }}</a>
                        <a class="dropdown-item w-auto" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('labels.reject') }}" onclick="OrderStatusUpdate('{{ $orderdata->id }}','6','{{ URL::to('admin/orders/update') }}')">{{ trans('labels.reject') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="progress-barrr">
                        @if (in_array($orderdata->status, [6, 7]))
                        <div class="progress-step is-active">
                            <div class="step-count"><i class="fa fa-close"></i></div>
                            <div class="step-description">
                                {{ $orderdata->status == '6' ? trans('labels.cancel_by_you') : trans('labels.cancel_by_user') }}
                            </div>
                        </div>
                        @else
                        @if (!in_array($orderdata->status, [1, 2, 3, 4, 5]))
                        <div class="progress-step is-active">
                            <div class="step-count"><i class="fa fa-exclamation-triangle"></i></div>
                            <div class="step-description">{{ trans('messages.wrong') }}</div>
                        </div>
                        @else
                        <div class="progress-step @if ($orderdata->status == '1') is-active @endif">
                            <div class="step-count"><i class="fa fa-bell"></i></div>
                            <div class="step-description">{{ trans('labels.new_order') }}</div>
                        </div>
                        <div class="progress-step @if ($orderdata->status == '2') is-active @endif">
                            <div class="step-count"><i class="fa fa-tasks"></i></div>
                            <div class="step-description">{{ trans('labels.preparing') }}</div>
                        </div>
                        @if ($orderdata->order_from != 'pos')
                        <div class="progress-step @if ($orderdata->status == '3') is-active @endif">
                            <div class="step-count"><i class="fa fa-thumbs-up"></i></div>
                            <div class="step-description">{{ trans('labels.ready') }}</div>
                        </div>
                        <div class="progress-step @if ($orderdata->status == '4') is-active @endif">
                            @if ($orderdata->order_type == 2)
                            <div class="step-count"><i class="fa fa-hourglass"></i></div>
                            <div class="step-description">{{ trans('labels.waiting_pickup') }}</div>
                            @else
                            <div class="step-count"><i class="fa fa-user"></i></div>
                            <div class="step-description">{{ trans('labels.on_the_way') }}
                                <br>{{ $orderdata['driver_info'] != '' ? '[' . $orderdata['driver_info']->name . ']' : '' }}
                            </div>
                            @endif
                        </div>
                        @endif
                        <div class="progress-step @if ($orderdata->status == '5') is-active @endif">
                            <div class="step-count"><i class="fa fa-check"></i></div>
                            <div class="step-description">{{ trans('labels.completed') }}</div>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ trans('labels.image') }}</th>
                                    <th>{{ trans('labels.item') }}</th>
                                    <th class="text-end">{{ trans('labels.unit_cost') }}</th>
                                    <th class="text-end">{{ trans('labels.qty') }}</th>
                                    <th class="text-end">{{ trans('labels.total') }}</th>
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
                                        <td><img src="{{ Helper::image_path($orders->item_image) }}" class="rounded hw-50" alt=""></td>
                                        <td>
                                            <img @if ($orders['item_type']==1) src="{{ Helper::image_path('veg.svg') }}" @else src="{{ Helper::image_path('nonveg.svg') }}" @endif class="item-type-img" alt="">
                                            {{ $orders->item_name }} @if ($orders->variation != '')
                                            [{{ $orders->variation }}]
                                            @endif <br>
                                            <?php
                                            $addons_name = explode(',', $orders->addons_name);
                                            $addons_price = explode(',', $orders->addons_price);
                                            $addonstotal = $orders->addons_total_price;
                                            ?>
                                            @if ($orders->addons_id != '')
                                            @foreach ($addons_name as $key => $val)
                                            <small class="text-muted">{{ $addons_name[$key] }} :
                                                <span>{{ Helper::currency_format($addons_price[$key]) }}</span></small><br>
                                            @endforeach
                                            @endif
                                        </td>
                                        <td class="text-end">{{ Helper::currency_format($orders->item_price) }}
                                            @if ($addonstotal != '0')
                                            <br><small class="text-muted">+
                                                {{ Helper::currency_format($addonstotal) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-end">{{ $orders->qty }}</td>
                                        <td class="text-end">{{ Helper::currency_format($total_price) }}</td>
                                    </tr>
                                <?php
                                }
                                $order_total = array_sum(array_column(@$data, 'total_price'));
                                ?>
                                <tr>
                                    <td class="text-end" colspan="4"> <strong>{{ trans('labels.subtotal') }}</strong> </td>
                                    <td class="text-end"><strong>{{ Helper::currency_format($order_total) }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-end" colspan="4"> <strong>{{ trans('labels.tax') }}</strong>  </td>
                                    <td class="text-end"><strong>{{ Helper::currency_format($orderdata->tax_amount) }}</strong></td>
                                </tr>
                                @if ($orderdata->discount_amount > 0)
                                <tr>
                                    <td class="text-end" colspan="4"> <strong>{{ trans('labels.discount') }}</strong> {{ $orderdata->offer_code != '' ? '(' . $orderdata->offer_code . ')' : '' }} </td>
                                    <td class="text-end"><strong>{{ Helper::currency_format($orderdata->discount_amount) }}</strong></td>
                                </tr>
                                @endif
                                @if ($orderdata->delivery_charge > 0)
                                <tr>
                                    <td class="text-end" colspan="4"> <strong>{{ trans('labels.delivery_charge') }}</strong> </td>
                                    <td class="text-end"><strong>{{ Helper::currency_format($orderdata->delivery_charge) }}</strong></td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-end" colspan="4">  <strong>{{ trans('labels.grand_total') }}</strong></td>
                                    <td class="text-end"><strong>{{ Helper::currency_format($orderdata->grand_total) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($orderdata->order_type == 1)
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
    @endif
</div>
@endsection
@section('script')
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/orders.js') }}"></script>
<script>
    var order_type = document.getElementById("order_type").value;
    function initMap() {
        if (order_type == 1) {
            var mapLayer = document.getElementById("map-layer");
            var centerCoordinates = new google.maps.LatLng("{{ @Helper::appdata()->lat }}",
                "{{ @Helper::appdata()->lang }}");
            var defaultOptions = {
                center: centerCoordinates,
                zoom: 17
            }
            var map = new google.maps.Map(mapLayer, defaultOptions);
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);
            var start = new google.maps.LatLng("{{ @Helper::appdata()->lat }}", "{{ @Helper::appdata()->lang }}");
            var end = new google.maps.LatLng("{{ $orderdata->lat }}", "{{ $orderdata->lang }}");
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ @Helper::appdata()->map }}&callback=initMap">
</script>
@endsection