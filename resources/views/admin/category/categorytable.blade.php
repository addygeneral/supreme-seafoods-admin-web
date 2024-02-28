<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{trans('labels.category')}}</th>
            <th>{{trans('labels.status')}}</th>
            <th>{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{url('admin/category/reorder_category')}}">
        @php $i = 1; @endphp
        @foreach ($getcategory as $category)
        <tr id="dataid{{$category->id}}" class="row1" data-id="{{$category->id}}">
            <td>@php echo $i++; @endphp</td>
            <td>{{$category->category_name}}</td>
            <td>
                @if($category->is_available == 1)
                    <a class="btn btn-sm btn-outline-success" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{$category->id}}','2','{{URL::to('admin/category/status')}}')" @endif><i class="fa-sharp fa-solid fa-check"></i></a>
                @else
                    <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{$category->id}}','1','{{URL::to('admin/category/status')}}')" @endif><i class="fa-sharp fa-solid fa-xmark"></i></a>
                @endif
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/category-'.$category->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$category->id}}','{{URL::to('admin/category/delete')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>