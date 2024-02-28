<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans('labels.print')}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{Helper::image_path(@Helper::appdata()->favicon)}}"><!-- Favicon icon -->
    <style type="text/css">
        body {
            width: 88mm;
            height: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            --webkit-font-smoothing: antialiased;
        }
        #printDiv {
            font-weight: 600;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }
        #printDiv div,#printDiv p,#printDiv a,#printDiv li,#printDiv td {
            -webkit-text-size-adjust: none;
        }
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
        @media print {
            @page {
                margin: 0;
            }
            body {
                margin: 1.6cm;
            }
        }
    </style>
</head>
<body>
    <div id="printDiv">
        <div class="">
            <table width="90%" border="0" cellpadding='2' cellspacing="2" align="center" bgcolor="#ffffff"
                style="padding-top:4px;">
                <tbody>
                    <tr>
                        <td style="font-size: 15px;color: #fffffff; font-family: 'Open Sans', sans-serif; line-height:18px; vertical-align: bottom; text-align: center;">
                            <h3 style="margin-top: 2px;margin-bottom: 2px;">{{@Helper::appdata()->short_title}}</h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;color: #fffffff; font-family: 'Open Sans', sans-serif; line-height:18px; vertical-align: bottom; text-align: center;">
                            #{{$orderdata->order_number}}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;color: #fffffff; font-family: 'Open Sans', sans-serif; line-height:18px; vertical-align: bottom; text-align: center;">
                            {{ trans('labels.order_type') }} : {{ $orderdata->order_type == '1' ? trans('labels.delivery') : trans('labels.pickup') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tbody>
                    <tr>
                        <td style="font-size: 12px; color: #fffffff;  font-family: 'Open Sans', sans-serif; line-height:18px; vertical-align: bottom; text-align: center;">
                            {{trans('labels.name')}} : @if($orderdata->user_id != null) {{@$orderdata['user_info']->name}} @else {{@$orderdata->name}} @endif
                            <br>{{trans('labels.email')}} : @if($orderdata->user_id != null) {{@$orderdata['user_info']->email}} @else {{@$orderdata->email}} @endif
                            <br>{{trans('labels.mobile')}} : @if($orderdata->user_id != null) {{@$orderdata['user_info']->mobile}} @else {{@$orderdata->mobile}} @endif
                            @if($orderdata->order_type == 1)
                                <br> {{trans('labels.address')}} : {{$orderdata->address}}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /Header -->
            <!-- Table Total -->
            <table width="90%" border="0" cellpadding="2" cellspacing="2" align="center" class="fullPadding">
                <tbody>
                    @if ($orderdata->order_notes != "")
                        <div style="padding: 5px 10px 5px 15px;">
                            <h5 style="margin-top: 2px;margin-bottom: 2px;">{{trans('labels.order_note')}} : <small style="color: gray">{{$orderdata->order_notes}}</small></h5>
                        </div>
                    @endif
                    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center" style="padding-top:2px">
                        <thead>
                            <tr>
                                <th style="font-size:15px;font-family:'Open Sans',sans-serif;color:#fffffff;font-weight:normal;line-height:1;vertical-align:top;padding-bottom:5px;text-align:left;"
                                    width="10%">#</th>
                                <th style="font-size:15px;font-family:'Open Sans',sans-serif;color:#fffffff;font-weight:normal;line-height:1;vertical-align:top;padding-bottom:5px;text-align:left;"
                                    width="50%">{{trans('labels.item')}}</th>
                                <th style="font-size:15px;font-family:'Open Sans',sans-serif;color:#fffffff;font-weight:normal;line-height:1;vertical-align:top;padding-bottom:5px;text-align:right;"
                                    width="10%">{{trans('labels.qty')}}</th>
                                <th style="font-size:15px;font-family:'Open Sans',sans-serif;color:#fffffff;font-weight:normal;line-height:1;vertical-align:top;padding-bottom:5px;text-align:right;"
                                    width="30%">{{trans('labels.total')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=1;
                                foreach ($ordersdetails as $orders) {
                                    $total_price = ($orders['item_price']+$orders['addons_total_price'])*$orders['qty'];
                                    $data[] = array("total_price" => $total_price,);
                            ?>
                            <tr>
                                <td style="font-size:15px;font-family:'Open Sans',sans-serif;color:#fffffff;line-height:18px;vertical-align:top;text-align:left;">{{$i}}</td>
                                <td style="font-size:12px;font-family:'Open Sans',sans-serif;color:#fffffff;line-height:18px;vertical-align:top;text-align:left;">
                                    {{$orders->item_name}} [{{$orders['item_type'] == 1 ? trans('labels.veg') : trans('labels.nonveg')}}]
                                    @if($orders->variation != "")
                                        [{{$orders->variation}}]
                                    @endif <br>
                                    <?php
                                        $addons_name = explode(',', $orders->addons_name);
                                        $addons_price = explode(',', $orders->addons_price);
                                        $addonstotal = 0;
                                    ?>
                                    @if($orders->addons_id != "")
                                        @foreach($addons_name as $key => $val)
                                        <span class="text-muted">{{$addons_name[$key]}} : <span>{{Helper::currency_format($addons_price[$key])}}</span></span><br>
                                        <?php $addonstotal += (float)$addons_price[$key]?>
                                        @endforeach
                                    @endif
                                </td>
                                <td style="font-size:12px;font-family:'Open Sans',sans-serif;color:#fffffff;line-height:18px;vertical-align:top;text-align:right;">{{$orders->qty}}</td>
                                <td style="font-size:12px;font-family:'Open Sans',sans-serif;color:#fffffff;line-height:18px;vertical-align:top;text-align:right;">
                                    {{-- {{Helper::currency_format($orders->item_price)}}
                                    @if($addonstotal != "0")
                                        <br><small class="text-muted">+ {{Helper::currency_format($addonstotal)}}</small>
                                    @endif --}}
                                    {{Helper::currency_format($total_price)}}
                                </td>
                            </tr>
                            <?php
                                    $i++;
                                }
                                $order_total = array_sum(array_column(@$data, 'total_price'));
                            ?>
                        </tbody>
                    </table>
                    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tbody>
                            <tr>
                                <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="70%"><strong>{{trans('labels.subtotal')}}</strong></td>
                                <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="30%"><strong>{{Helper::currency_format($order_total)}}</strong></td>
                            </tr>
                            <tr>
                                <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="70%"><strong>{{trans('labels.tax')}}</strong></td>
                                <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="30%"><strong>{{Helper::currency_format($orderdata->tax_amount)}}</strong></td>
                            </tr>
                            @if ($orderdata->discount_amount > 0)
                                <tr>
                                    <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="70%"><strong>{{trans('labels.discount')}} {{ $orderdata->offer_code != "" ? '('.$orderdata->offer_code.')' : '' }}</strong></td>
                                    <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="30%"><strong>{{Helper::currency_format($orderdata->discount_amount)}}</strong></td>
                                </tr>
                            @endif
                            @if ($orderdata->delivery_charge > 0)
                                <tr>
                                    <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="70%"><strong>{{trans('labels.delivery_charge')}}</strong></td>
                                    <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="30%"><strong>{{Helper::currency_format($orderdata->delivery_charge)}}</strong></td>
                                </tr>
                            @endif
                            <tr>
                                <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="70%"><strong>{{trans('labels.grand_total')}}</strong></td>
                                <td style="font-size: 15px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right;"
                                    width="30%"><strong>{{Helper::currency_format($orderdata->grand_total)}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </tbody>
            </table>
        </div>
    </div>
    <button id="btnPrint" class="hidden-print center">{{trans('labels.print')}}</button>
    <script>
        const $btnPrint = document.querySelector("#btnPrint");
        $btnPrint.addEventListener("click", () => {
            window.print();
        });
    </script>
</body>
