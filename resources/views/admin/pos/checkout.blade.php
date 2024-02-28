@extends('admin.theme.default')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/admin/home') }}">{{ trans('labels.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('labels.pos') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            @if (session()->get('cartdata') != '' && count(session()->get('cartdata')) > 0)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>POS checkout</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('labels.your_cart')}} ({{session()->get('cartdata') != "" ? count(session()->get('cartdata')) : 0 }} {{trans('labels.items')}})</h4>
                            </div>
                            <span id="cartemsg"></span>
                            <div class="table-responsive">
                                <table class="table table-xs mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{trans('labels.image')}}</th>
                                            <th>{{trans('labels.items')}}</th>
                                            <th>{{trans('labels.price')}}</th>
                                            <th>{{trans('labels.qty')}}</th>
                                            <th>{{trans('labels.total')}}</th>
                                            <th>{{trans('labels.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totaltax = 0;
                                        $totaltaxamount = 0;
                                        $order_total = 0;
                                        session()->get('cartdata') != "" ? $cartarray = session()->get('cartdata') : $cartarray = array();
                                        ?>
                                        @foreach ($cartarray as $setid => $item)
                                            <tr>
                                                <td><img src="{{ Helper::image_path($item['image_name']) }}"
                                                        class="hw-50 rounded" alt=""></td>
                                                <td>
                                                    <p class="mb-1">
                                                        <img @if($item['item_type'] == 1) src="{{Helper::image_path('veg.svg')}}" @else src="{{Helper::image_path('nonveg.svg')}}" @endif class="item-type-image" alt="">
                                                        <b>{{ $item['item_name'] }} {{ $item['variation_name'] != '' ? '[' . $item['variation_name'] . ']' : '' }}</b>
                                                    </p>
                                                    @php
                                                        $addonsttlprice = $item['addons_total_price'];
                                                        $addons_id = explode(',', $item['addons_id']);
                                                        $addons_price = explode(',', $item['addons_price']);
                                                        $addons_name = explode(',', $item['addons_name']);
                                                    @endphp
                                                    @if ($item['addons_id'] != '')
                                                        @foreach ($addons_id as $key => $addons)
                                                            <div class="cart-addons-wrap">
                                                                <div class="cart-addons">
                                                                    <span>{{ $addons_name[$key] }}</span> : {{ Helper::currency_format($addons_price[$key]) }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @php
                                                        $tax = number_format(($item['item_price'] * $item['qty'] * $item['tax']) / 100, 2);
                                                        $total_price = ($item['item_price'] + $addonsttlprice) * $item['qty'];
                                                        $totaltaxamount += (float) $tax;
                                                        $order_total += (float) $total_price;
                                                    @endphp

                                                </td>
                                                <td>{{ Helper::currency_format($item['item_price']) }}
                                                    @if ($addonsttlprice > 0)
                                                        <br> <small> + {{Helper::currency_format($addonsttlprice)}}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="pro-add">
                                                        <div class="cursor-pointer" id="minus" onclick="qtyupdate('{{$setid}}','minus','{{URL::to('admin/pos/qtyupdate')}}')" value="minus value">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </div>
                                                        <input type="number" name="number" min="1" max="10" value="{{$item['qty']}}" readonly>
                                                        <div class="cursor-pointer" id="plus" onclick="qtyupdate('{{$setid}}','plus','{{URL::to('admin/pos/qtyupdate')}}')" value="plus value">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ Helper::currency_format($total_price) }}
                                                    @if ($tax > 0)
                                                        <br> <small>(+ {{ Helper::currency_format($tax) }} {{ trans('labels.tax') }})</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn text-danger" href="javascript:void(0)" onclick="deletecartitem('{{$setid}}','{{URL::to('admin/pos/deleteitem')}}')">
                                                        <span class="btn-icon-left bg-primary"><i class="fa fa-trash text-white"></i> </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tfoot>
                                        <tr>
                                            <td colspan="7"><a href="{{ URL::to('admin/pos/items') }}" class="btn rounded btn-info"> <i class="fa fa-arrow-left"></i> Continue shopping</a></td>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header px-0">
                                <h4 class="card-title">{{ trans('labels.discount') }}</h4>
                            </div>
                            @if (session()->get('discount_amount'))
                                <form action="{{URL::to('admin/pos/remove-discount')}}" method="POST">
                                    @csrf
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{session()->get('discount_amount')}}" placeholder="{{trans('messages.enter_amount')}}" aria-label="{{trans('messages.enter_amount')}}" aria-describedby="basic-addon2" disabled>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">{{trans('labels.remove')}}</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form action="{{URL::to('admin/pos/apply-discount')}}" method="POST">
                                    @csrf
                                    <div class="input-group mb-1">
                                        <input type="hidden" name="sub_total" id="sub_total" value="{{$order_total}}">
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{old('amount')}}" placeholder="{{trans('messages.enter_amount')}}" aria-label="{{trans('messages.enter_amount')}}" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">{{trans('labels.apply')}}</button>
                                        </div>
                                    </div>
                                    @error('amount') <span class="text-danger"> {{$message}} </span> @enderror
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header px-0">
                                <h4 class="card-title">{{ trans('labels.cart_summery') }}</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                @php
                                    if(session()->get('discount_amount')){
                                        $discount_amount = session()->get('discount_amount');
                                    }else{
                                        $discount_amount = 0;
                                    }
                                    $grand_total = $order_total - $discount_amount + $totaltaxamount;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between">{{trans('labels.subtotal')}} <strong>{{Helper::currency_format($order_total)}}</strong> </li>
                                <li class="list-group-item d-flex justify-content-between">{{trans('labels.tax')}} <strong>{{Helper::currency_format($totaltaxamount)}}</strong> </li>
                                <li class="list-group-item d-flex justify-content-between">{{trans('labels.discount')}} <strong>- {{Helper::currency_format($discount_amount)}}</strong> </li>
                                <li class="list-group-item d-flex justify-content-between"><strong>{{trans('labels.grand_total')}}</strong> <strong>{{Helper::currency_format($grand_total)}}</strong> </li>
                            </ul>
                            <div id="emsg"></div>
                            <div class="card-footer">
                                <button class="btn btn-block btn-info" onclick="placeorder('{{URL::to('admin/pos/placeorder')}}','{{URL::to('admin/pos/orders')}}')">
                                    {{ trans('labels.place_order') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="tax" id="tax" value="{{@$totaltaxamount}}">
                <input type="hidden" name="discount_amount" id="discount_amount" value="{{@$discount_amount}}">
                <input type="hidden" name="grand_total" id="grand_total" value="{{@$grand_total}}">
            @else
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-center">
                            <h4 class="text-muted">{{ trans('labels.no_data') }}</h4>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
<script src="{{ url('resources/views/admin/pos/pos.js') }}"></script>
@endsection
