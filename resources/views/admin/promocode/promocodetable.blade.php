<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.offer_name') }}</th>
            <th>{{ trans('labels.offer_code') }}</th>
            <th>{{ trans('labels.discount') }}</th>
            <th>{{ trans('labels.status') }} </th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getpromocode as $promocode)
            <tr id="dataid{{ $promocode->id }}">
                <td>@php echo $i++; @endphp</td>
                <td>{{ $promocode->offer_name }}</td>
                <td>{{ $promocode->offer_code }}</td>
                <td>{{ $promocode->offer_type == 1 ? Helper::currency_format($promocode->offer_amount) : $promocode->offer_amount . '%' }}
                </td>
                <td>
                    @if ($promocode->is_available == 1)
                        <a class="btn btn-sm btn-outline-success"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $promocode->id }}','2','{{ URL::to('admin/promocode/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-outline-danger"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $promocode->id }}','1','{{ URL::to('admin/promocode/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-info" href="{{ URL::to('admin/promocode-' . $promocode->id) }}"><i
                            class="fa-solid fa-pen-to-square"></i></a>
                    <a class="btn btn-sm btn-outline-danger d-none"
                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="deletedata('{{ URL::to('admin/promocode/delete-' . $promocode->id) }}')" @endif><i
                            class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
