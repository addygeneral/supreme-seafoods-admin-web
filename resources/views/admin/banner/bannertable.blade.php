<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('labels.image') }}</th>
            <th>{{ trans('labels.category') }}</th>
            <th>{{ trans('labels.item') }}</th>
            <th>{{ trans('labels.status') }}</th>
            <th>{{ trans('labels.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getbanner as $banner)
            @if ($banner->section == $section)
                <tr id="dataid{{ $banner->id }}">
                    <td>@php echo $i++; @endphp</td>
                    <td><img src='{{ Helper::image_path($banner->image) }}' class='img-fluid rounded hw-50'></td>
                    <td>
                        @if ($banner->type == '1')
                            {{ @$banner['category_info']->category_name }}
                        @else
                            --
                        @endif
                    </td>
                    <td>
                        @if ($banner->type == '2')
                            {{ @$banner['item_info']->item_name }}
                        @else
                            --
                        @endif
                    </td>
                    <td>
                        @if ($banner->is_available == 1)
                            <a class="btn btn-sm btn-outline-success"
                                @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $banner->id }}','2','{{ URL::to('admin/banner/status') }}')" @endif><i
                                    class="fa-sharp fa-solid fa-check"></i></a>
                        @else
                            <a class="btn btn-sm btn-outline-danger"
                                @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $banner->id }}','1','{{ URL::to('admin/banner/status') }}')" @endif><i
                                    class="fa-sharp fa-solid fa-xmark"></i></a>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-info"
                            href="{{ URL::to('admin/bannersection-' . $banner->section . '-' . $banner->id) }}"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)"
                            @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="DeleteData('{{ $banner->id }}','{{ URL::to('admin/banner/destroy') }}')" @endif><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
