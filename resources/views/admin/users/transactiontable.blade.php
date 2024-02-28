<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.date') }}</th>
            <th>{{ trans('labels.description') }}</th>
            <th>{{ trans('labels.amount') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($gettransactions as $tdata)
            <tr>
                <td>@php echo $i++; @endphp</td>
                <td>{{ Helper::date_format($tdata->created_at) }}</td>
                <td>
                    @if (in_array($tdata->transaction_type, [3, 4, 5, 6, 7, 8, 9, 10, 12, 13]))
                        {{ trans('labels.wallet_recharge') }}
                        [
                        @if ($tdata->transaction_type == 12)
                            {{ trans('labels.added_by_admin') }}
                        @elseif ($tdata->transaction_type == 13)
                            {{ trans('labels.deducted_by_admin') }}
                        @endif
                        @if ($tdata->transaction_type == 3)
                            {{ trans('labels.razorpay') }} :
                        @elseif ($tdata->transaction_type == 4)
                            {{ trans('labels.stripe') }} :
                        @elseif ($tdata->transaction_type == 5)
                            {{ trans('labels.flutterwave') }} :
                        @elseif ($tdata->transaction_type == 6)
                            {{ trans('labels.paystack') }} :
                        @elseif ($tdata->transaction_type == 7)
                            {{ trans('labels.mercadopago') }} :
                        @elseif ($tdata->transaction_type == 8)
                            {{ trans('labels.myfatoorah') }} :
                        @elseif ($tdata->transaction_type == 9)
                            {{ trans('labels.paypal') }} :
                        @elseif ($tdata->transaction_type == 10)
                            {{ trans('labels.toyyibpay') }} :
                        @endif
                        @if (in_array($tdata->transaction_type, [3, 4, 5, 6, 7, 8, 9, 10]))
                            {{ $tdata->transaction_id }}
                        @endif
                        ]
                    @elseif ($tdata->transaction_type == 2)
                        {{ trans('labels.order_cancelled') }}
                    @elseif ($tdata->transaction_type == 1)
                        {{ trans('labels.order_placed') }}
                    @elseif ($tdata->transaction_type == 11)
                        {{ trans('labels.referral_earning') }}
                        [{{ $tdata->username }}]
                    @else
                        -
                    @endif
                    @if (in_array($tdata->transaction_type, [1, 2]))
                        [{{ $tdata->order_number }}]
                    @endif
                </td>
                <td
                    class="{{ in_array($tdata->transaction_type, [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]) == true ? 'text-success' : 'text-danger' }}">
                    {{ Helper::currency_format($tdata->amount) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
