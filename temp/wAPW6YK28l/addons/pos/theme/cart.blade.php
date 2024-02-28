@if(session('cart'))
    @foreach(session('cart') as $id => $details)
        <div class="media border-bottom-1 pt-3 pb-3">
            <img width="100" src="{{ $details['item_image'] }}" class="img-fluid mr-3">
            <div class="media-body">
                <h6><span class="text-primary">{{ $details['item_name'] }}</span> {{$details['variation_name']}}</h6>

                @php
                $addonsttlprice = 0;
                @endphp

                @if ($details['addons_id'] != "")
                <p class="mb-0">
                    <?php 
                    $addons_id = explode(",",$details['addons_id']);
                    $addons_price = explode(",",$details['addons_price']);
                    $addons_name = explode(",",$details['addons_name']); 
                    ?>
                    @foreach ($addons_id as $key =>  $addons)
                    <div class="cart-addons-wrap">
                        <div class="cart-addons">
                            <b>{{$addons_name[$key]}}</b> : {{Auth::user()->currency}}{{number_format($addons_price[$key], 2)}} * {{$details['qty']}}
                        </div>
                    </div>

                    @php
                        $addonsttlprice = $addonsttlprice + $addons_price[$key]
                    @endphp
                    @endforeach
                </p>
                @endif
                <div class="pro-add">
                    <div class="value-button" id="decrease" onclick="qtyupdate('{{$id}}','decreaseValue')" value="Decrease Value">
                        <i class="fa fa-minus-circle"></i>
                    </div>
                    <input type="number" id="number_34" name="number" value="{{$details['qty']}}" readonly="" min="1" max="10">
                    <div class="value-button" id="increase" onclick="qtyupdate('{{$id}}','increase')" value="Increase Value">
                        <i class="fa fa-plus-circle"></i>
                    </div>
                </div>

                @if ($details['item_notes'] != "")
                    <div class="alert alert-success">{{$details['item_notes']}}</div>
                @endif
            </div>

            <div class="pb-3 text-center">
                <p class="m-0 pr-3">{{Auth::user()->currency}}{{number_format($details['variation_price'],2)}} * {{$details['qty']}}</p>
                <h4 class="m-1">{{Auth::user()->currency}}{{ number_format(($details['variation_price'] * $details['qty']) + ($addonsttlprice * $details['qty']),2) }}</h4>
            </div>
            <div class="pro-add">
                <i class="fa fa-trash" onclick="deleteitem('{{$id}}')"></i>
            </div>
        </div>
        @php 
            $data[] = array(
                "total_price" => ($details['variation_price'] * $details['qty']) + ($addonsttlprice * $details['qty']),
                "tax" => ($details['qty']*$details['variation_price'])*@$details['tax']/100,
            );

            $subtotal = array_sum(array_column(@$data, 'total_price')); 
            $tax = array_sum(array_column(@$data, 'tax'));
            $grandtotal = array_sum(array_column(@$data, 'total_price'))+$tax;
        @endphp
    @endforeach
@else
    <h5 class="text-center pb-3">
        <i class="icon-emotsmile"></i>
        <p>No Product Added</p>
    </h5>
@endif

<div class="cart-delivery-type open">
    <label for="cart-pickup">
        <input type="radio" name="cart-delivery" id="cart-pickup" checked value="2">
        <div class="cart-delivery-type-box">
            <img src="{!! asset('storage/app/public/front/images/delivery.png') !!}" height="40" width="40" alt="">
            <p>{{ trans('labels.pickup') }}</p>
        </div>
    </label>
    <label for="cart-delivery">
        <input type="radio" name="cart-delivery" id="cart-delivery" value="1">
        <div class="cart-delivery-type-box">
            <img src="{!! asset('storage/app/public/front/images/pickup-truck.png') !!}" height="40" width="40" alt="">                                   
            <p>{{ trans('labels.delivery') }}</p>
        </div>
    </label>
</div>

<div id="customer-details">
    <input type="hidden" class="form-control" name="users_id" id="users_id">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="{{ trans('messages.enter_fullname') }}" name="name" id="name"> 
    </div>

    <div class="form-group">
        <input type="text" class="form-control" placeholder="{{ trans('messages.enter_email') }}" name="email" id="email"> 
    </div>

    <div class="form-group">
        <input type="text" class="form-control" placeholder="{{ trans('messages.enter_mobile') }}" name="mobile" id="mobile"> 
    </div>
</div>


<div id="delivery-details" style="display: none;">
    <div class="form-group">
        @if (env('Environment') == 'sendbox')
            <input type="text" class="form-control" placeholder="{{ trans('messages.enter_delivery_address') }}" name="address" id="address" value="New York, NY, USA" required="" readonly="" autocomplete="on" >
        @else
            <input type="text" class="form-control" placeholder="{{ trans('messages.enter_delivery_address') }}" name="address" id="address" required="" autocomplete="on"> 
        @endif
    </div>

    <div class="form-group">
        @if (env('Environment') == 'sendbox')
            <input type="text" class="form-control" name="building" id="building" placeholder="{{ trans('messages.enter_building') }}" value="4043" readonly="">
        @else
            <input type="text" class="form-control" placeholder="{{ trans('messages.enter_building') }}" name="building" id="building" required=""> 
        @endif
        
    </div>

    <div class="form-group">
        @if (env('Environment') == 'sendbox')
            <input type="text" class="form-control" name="landmark" id="landmark" placeholder="{{ trans('messages.enter_landmark') }}" value="Central Park" readonly="">
        @else
            <input type="text" class="form-control" placeholder="{{ trans('messages.enter_landmark') }}" name="landmark" id="landmark" required=""> 
        @endif
    </div>

    <div class="form-group">
        <select class="form-control" name="pincode" id="pincode">
            <option value="" data-deliverycharge="0">{{ trans('messages.select_pincode') }}</option>
            @foreach($getpincode as $pincode)
            <option value="{{$pincode->pincode}}" data-deliverycharge="{{number_format($pincode->delivery_charge,2)}}">{{$pincode->pincode}} - {{Auth::user()->currency}}{{number_format($pincode->delivery_charge,2)}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <textarea name="notes" id="notes" class="form-control" placeholder="{{ trans('messages.enter_order_note') }}" rows="3"></textarea>
</div>

@if (env('Environment') == 'sendbox')
    <input type="hidden" id="lat" name="lat" value="40.7127753" />
    <input type="hidden" id="lang" name="lang" value="-74.0059728" />
    <input type="hidden" id="city" name="city" placeholder="city" value="New York" /> 
    <input type="hidden" id="state" name="state" placeholder="state" value="NY" /> 
    <input type="hidden" id="country" name="country" placeholder="country" value="US" />
@else
    <input type="hidden" id="lat" name="lat" />
    <input type="hidden" id="lang" name="lang" />
    <input type="hidden" id="city" name="city" /> 
    <input type="hidden" id="state" name="state" /> 
    <input type="hidden" id="country" name="country" />
@endif

<input type="hidden" name="subtotal" id="subtotal" value="{{@$subtotal}}">
<input type="hidden" name="tax" id="tax" value="{{@$tax}}">
<input type="hidden" name="delivery_charge" id="delivery_charge" value="0">
<input type="hidden" name="paid_amount" id="paid_amount" value="{{@$grandtotal}}">

<table class="table table-clear">
    <tbody>
        <tr>
            <td class="left">
                <strong>Subtotal</strong>
            </td>
            <td class="right">
                <strong>{{Auth::user()->currency}}{{number_format(@$subtotal, 2)}}</strong>
            </td>
        </tr>
        <tr>
            <td class="left">
                <strong>Tax</strong>
            </td>
            <td class="right">
                <strong>{{Auth::user()->currency}}{{number_format(@$tax, 2)}}</strong>
            </td>
        </tr>
        <tr id="shipping_charge">
            <td class="left">
                <strong>Delivery charge</strong>
            </td>
            <td class="right">
                <strong id="shipping_amount"></strong>
            </td>
        </tr>
        <tr>
            <td class="left">
                <strong>Total</strong>
            </td>
            <td class="right">
                <strong id="grand_total">{{Auth::user()->currency}}{{number_format(@$grandtotal, 2)}}</strong>
            </td>
        </tr>        
    </tbody>
</table>
<button class="btn btn-block btn btn-primary mt-2" onclick="order()">Place order</button>