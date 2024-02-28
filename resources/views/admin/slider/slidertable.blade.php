<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{trans('labels.image')}}</th>
            <th>{{trans('labels.title')}}</th>
            <th>{{trans('labels.category')}}</th>
            <th>{{trans('labels.item')}}</th>
            <th>{{trans('labels.description')}}</th>
            <th>{{trans('labels.status')}}</th>
            <th>{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getslider as $slider)
        <tr id="dataid{{$slider->id}}">
            <td>@php echo $i++; @endphp</td>
            <td><img src='{{Helper::image_path($slider->image)}}' class='img-fluid rounded hw-50'></td>
            <td>{{$slider->title}}</td>
            <td>@if($slider->type == "1") {{@$slider['category_info']->category_name}} @else -- @endif</td>
            <td>@if($slider->type == "2") {{@$slider['item_info']->item_name}} @else -- @endif</td>
            <td>{{$slider->description}}</td>
            <td>
                @if ($slider->is_available == 1)
                    <a class="btn btn-sm btn-outline-success" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{$slider->id}}','2','{{ URL::to('admin/slider/status')}}')" @endif><i class="fa-sharp fa-solid fa-check"></i></a>
                @else
                    <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{$slider->id}}','1','{{ URL::to('admin/slider/status')}}')" @endif><i class="fa-sharp fa-solid fa-xmark"></i></a>
                @endif
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/slider-'.$slider->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="DeleteData('{{$slider->id}}','{{ URL::to('admin/slider/destroy')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>