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
        @foreach ($gettutorials as $tutorial)
        <tr id="dataid{{$tutorial->id}}">
            <td>@php echo $i++; @endphp</td>
            <td><img src='{{Helper::image_path($tutorial->image)}}' class='img-fluid rounded hw-50'></td>
            <td>{{$tutorial->title}}</td>
            <td>{{$tutorial->description}}</td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/tutorial-'.$tutorial->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$tutorial->id}}','{{URL::to('admin/tutorial/delete')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>