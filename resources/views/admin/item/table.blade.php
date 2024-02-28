<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.category') }}</th>
            <th>{{ trans('labels.featured') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody id="tabledetails"  data-url="{{url('admin/item/reorder_item')}}">
        @php $i = 1; @endphp
        @foreach ($getitem as $item)
        <tr class="row1" data-id="{{$item->id}}">
            <td>@php echo $i++; @endphp</td>
            <td><img @if ($item->item_type == 1) src="{{ Helper::image_path('veg.svg') }}" @else src="{{
                Helper::image_path('nonveg.svg') }}" @endif
                class="item-type-img" alt=""> {{ $item->item_name }}</td>
            <td>{{ @$item['category_info']->category_name }}</td>
            <td>
                @if ($item->is_featured == 1)
                <a class="btn btn-sm btn-outline-success" @if (env('Environment')=='sendbox' ) onclick="myFunction()"
                    @else onclick="StatusFeatured('{{ $item->id }}','2','{{ URL::to('admin/item/featured') }}')"
                    @endif><i class="fa-sharp fa-solid fa-check"></i></a>
                @else
                <a class="btn btn-sm btn-outline-danger" @if (env('Environment')=='sendbox' ) onclick="myFunction()"
                    @else onclick="StatusFeatured('{{ $item->id }}','1','{{ URL::to('admin/item/featured') }}')"
                    @endif><i class="fa-sharp fa-solid fa-xmark"></i></a>
                @endif
            </td>
            <td>
                @if ($item->item_status == 1)
                <a class="btn btn-sm btn-outline-success" @if (env('Environment')=='sendbox' ) onclick="myFunction()"
                    @else onclick="StatusUpdate('{{ $item->id }}','2','{{ URL::to('admin/item/status') }}')" @endif> <i
                        class="fa-sharp fa-solid fa-check"></i></a>
                @else
                <a class="btn btn-sm btn-outline-danger" @if (env('Environment')=='sendbox' ) onclick="myFunction()"
                    @else onclick="StatusUpdate('{{ $item->id }}','1','{{ URL::to('admin/item/status') }}')" @endif> <i
                        class="fa-sharp fa-solid fa-xmark"></i></a>
                @endif
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{ URL::to('admin/item-' . $item->id) }}"> <i
                        class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" @if (env('Environment')=='sendbox' ) onclick="myFunction()"
                    @else onclick="Delete('{{ $item->id }}','{{ URL::to('admin/item/delete') }}')" @endif> <i
                        class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>