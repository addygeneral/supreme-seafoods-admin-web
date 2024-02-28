@if (count($getgalleries) > 0)
    <div class="row">
        @foreach ($getgalleries as $gallery)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
            <div class="card border-0 text-center">
                <div class="card-body border-0">
                    <img src="{{Helper::image_path($gallery->image)}}" class="img-fluid gallery-img rounded" alt="">
                    <div class="mt-2">
                        <a class="btn btn-sm btn-outline-info" href="{{URL::to('admin/gallery-'.$gallery->id)}}" ><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-sm btn-outline-danger" href="#" @if (env('Environment')=='sendbox') onclick="myFunction()" @else onclick="Delete('{{$gallery->id}}','{{URL::to('admin/gallery/delete')}}')" @endif ><i class="fa fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
@include('admin.nodata')
@endif