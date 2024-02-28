<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>{{trans('labels.name')}}</th>
            <th>{{trans('labels.coordinates')}}</th>
            <th>{{trans('labels.delivery_charge')}}</th>
            <th>{{trans('labels.action')}}</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($zonedata as $zone)
        <tr id="dataid{{$zone->id}}">
            <td>@php echo $i++; @endphp</td>
            <td>{{$zone->name}}</td>
            <td class="w-50">{{$zone->coordinates }}</td>
            <td>{{$zone->delivery_charge}}</td>
            <td>
                <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/zone/'.$zone->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-sm btn-outline-danger" @if(env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$zone->id}}','{{URL::to('admin/zone/delete')}}')" @endif><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>