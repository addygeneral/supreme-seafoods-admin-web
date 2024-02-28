<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.order_number') }}</th>
            <th>{{ trans('labels.date') }}</th>
            <th>{{ trans('labels.user_info') }}</th>
            <th>{{ trans('labels.order_type') }}</th>
            <th>{{ trans('labels.grand_total') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
            foreach ($getorders as $orderdata) {
                ?>
        <tr id="dataid{{ $orderdata->id }}">
            <td> <?php echo $i++; ?></td>
            <td><a href="{{ URL::to('admin/invoice/' . $orderdata->id) }}">{{ $orderdata->order_number }}</a></td>
            <td>{{ Helper::date_format($orderdata->created_at) }}</td>
            <td>
                  @if($orderdata->user_id == null)
                    {{ @$orderdata->name }}
                  @else
                    {{ @$orderdata['user_info']->name }}
                  @endif
            </td>
            <td>{{ $orderdata->order_type == 1 ? trans('labels.delivery') : trans('labels.pickup') }}</td>
            <td>{{ Helper::currency_format($orderdata->grand_total) }}
                <br>
                @if ($orderdata->status == 5)
                    <small class="text-success"> <i class="fa-regular fa-clock"></i> {{ trans('labels.paid') }}</small>
                @else
                    <small class="text-danger"> <i class="fa-regular fa-check"></i> {{ trans('labels.unpaid') }}</small>
                @endif
            </td>
            <td>
                @if ($orderdata->status == '1')
                    <small class="text-order-placed">{{ trans('labels.placed') }}</small>
                @elseif($orderdata->status == '2')
                    <small class="text-order-preparing">{{ trans('labels.preparing') }}</small>
                @elseif($orderdata->status == '3')
                    <small class="text-order-ready">{{ trans('labels.ready') }}</small>
                @elseif($orderdata->status == '4')
                    @if ($orderdata->order_type == 2)
                        <small class="text-order-waitingpickup">{{ trans('labels.waiting_pickup') }}</small>
                    @else
                        <small class="text-order-ontheway">{{ trans('labels.on_the_way') }}</small>
                    @endif
                @elseif($orderdata->status == '5')
                    <small class="text-order-completed">{{ trans('labels.completed') }}</small>
                @elseif($orderdata->status == '6' || $orderdata->status == '7')
                    <small class="text-order-cancelled">{{ trans('labels.cancelled') }}</small>
                @else
                    --
                @endif
            </td>
            <td>
                <a class="btn btn-sm btn-light" title="{{ trans('labels.view') }}" href="{{ URL::to('admin/invoice/' . $orderdata->id) }}"><i class="fa-regular fa-eye"></i></a>
                <a class="btn btn-sm btn-light" title="{{ trans('labels.print') }}" href="{{ URL::to('admin/print/' . $orderdata->id) }}"><i class="fa-regular fa-print"></i></a>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
