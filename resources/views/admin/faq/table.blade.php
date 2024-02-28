<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{trans('labels.title')}}</th>
            <th>{{trans('labels.description')}}</th>
            <th>{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getfaqs as $faq)
        <tr id="dataid{{$faq->id}}">
            <td>@php echo $i++; @endphp</td>
            <td>{{$faq->title}}</td>
            <td>{{$faq->description}}</td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/faq-'.$faq->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$faq->id}}','{{URL::to('admin/faq/delete')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>