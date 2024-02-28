@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="form-validation">
                        <form action="{{URL::to('admin/tutorial/update-'.$tutorialdata->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
 <div class="row">
                                    <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="">{{trans('labels.title')}} <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" name="title" value="{{$tutorialdata->title}}" placeholder="{{trans('labels.title')}}" >
                                    @error('title') <span class="text-danger">{{$message}}</span> @enderror
                           </div>
                           <div class="form-group">
                                <label class="col-form-label" for="">{{trans('labels.image')}} (300 x 300) <span class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                    @error('image') <span class="text-danger">{{$message}}</span><br> @enderror
                                    <img src="{{Helper::image_path($tutorialdata->image)}}" alt="" class="img-fluid rounded hw-50 mt-1">
                            </div>
                                    </div>
                                    <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="">{{trans('labels.description')}} <span class="text-danger">*</span> </label>
                                    <textarea class="form-control" name="description" rows="5" placeholder="{{trans('labels.description')}}">{{$tutorialdata->description}}</textarea>
                                    @error('description') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
</div>
                                    </div>
                            <div class="form-group text-end">
                                    <a href="{{ URL::to('admin/tutorial') }}"
                                        class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection