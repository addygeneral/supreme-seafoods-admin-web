<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{trans('labels.name')}}</th>
            <th>{{trans('labels.designation')}}</th>
            <th>{{trans('labels.social_links')}}</th>
            <th>{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($getteams as $team)
        <tr id="dataid{{$team->id}}">
            <td>@php echo $i++; @endphp</td>
            <td>{{$team->title}}</td>
            <td>{{$team->subtitle}}</td>
            <td>
                <a class="btn btn-sm btn-outline-primary" href="{{ $team->fb }}" target="_blank"> <i class="fab fa-facebook-square"></i> </a>
                <a class="btn btn-sm btn-outline-primary" href="{{ $team->youtube }}" target="_blank"> <i class="fab fa-youtube"></i> </a>
                <a class="btn btn-sm btn-outline-primary" href="{{ $team->insta }}" target="_blank"> <i class="fab fa-instagram-square"></i> </a>
            </td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/our-team-'.$team->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$team->id}}','{{URL::to('admin/our-team/delete')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>