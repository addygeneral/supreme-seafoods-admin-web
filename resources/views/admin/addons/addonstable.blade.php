<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.price') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1 @endphp
        @foreach ($getaddons as $addons)
            <tr id="dataid{{ $addons->id }}">
                <td>@php echo $i++ @endphp</td>
                <td>{{ $addons->name }}</td>
                <td>{{ Helper::currency_format($addons->price) }}</td>
                <td>
                    @if ($addons->is_available == 1)
                        <a class="btn btn-sm btn-outline-success"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addons->id }}','2','{{ URL::to('admin/addons/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-check"></i></a>
                    @else
                        <a class="btn btn-sm btn-outline-danger"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addons->id }}','1','{{ URL::to('admin/addons/status') }}')" @endif><i
                                class="fa-sharp fa-solid fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-info" href="{{ URL::to('admin/addons-' . $addons->id) }}"><i
                            class="fa-solid fa-pen-to-square"></i></a>
                    <a class="btn btn-sm btn-outline-danger"
                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $addons->id }}','{{ URL::to('admin/addons/delete') }}')" @endif><i
                            class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
