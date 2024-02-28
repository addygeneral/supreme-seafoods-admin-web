<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{trans('labels.image')}}</th>
            <th>{{trans('labels.title')}}</th>
            <th>{{trans('labels.description')}}</th>
            <th>{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getblogs as $blog)
        <tr>
            <td>@php echo $i++; @endphp</td>
            <td><img src='{{Helper::image_path($blog->image)}}' class='img-fluid rounded hw-50'></td>
            <td>{{$blog->title}}</td>
            <td>{{Str::limit($blog->description, 200)}}</td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/blogs-'.$blog->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$blog->id}}','{{URL::to('admin/blogs/delete')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>