<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{trans('labels.subcategory')}}</th>
            <th>{{trans('labels.category')}}</th>
            <th>{{trans('labels.status')}}</th>
            <th>{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getsubcategory as $category)
        <tr id="dataid{{$category->id}}">
            <td>@php echo $i++; @endphp</td>
            <td>{{$category->subcategory_name}}</td>
            <td>{{@$category['category_info']->category_name}}</td>
            <td>
                @if ($category->is_available == 1)
                    <a class="btn btn-sm btn-outline-success" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{$category->id}}','2','{{ URL::to('admin/sub-category/status')}}')" @endif><i class="fa-sharp fa-solid fa-check"></i></a>
                @else
                    <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{$category->id}}','1','{{ URL::to('admin/sub-category/status')}}')" @endif><i class="fa-sharp fa-solid fa-xmark"></i></a>
                @endif
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/sub-category-'.$category->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$category->id}}','{{URL::to('admin/sub-category/delete')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>