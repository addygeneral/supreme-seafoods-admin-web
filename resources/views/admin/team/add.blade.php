@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/our-team/store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ old('title') }}" placeholder="{{ trans('labels.name') }}">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.designation') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="subtitle"
                                                value="{{ old('subtitle') }}" placeholder="{{ trans('labels.designation') }}">
                                            @error('subtitle')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.facebook_link') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="fb"
                                                value="{{ old('fb') }}"
                                                placeholder="{{ trans('labels.facebook_link') }}">
                                            @error('fb')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.youtube_link') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="youtube"
                                                value="{{ old('youtube') }}"
                                                placeholder="{{ trans('labels.youtube_link') }}">
                                            @error('youtube')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.instagram_link') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="insta"
                                                value="{{ old('insta') }}"
                                                placeholder="{{ trans('labels.instagram_link') }}">
                                            @error('insta')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.description') }}
                                                <span class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="description" rows="5" placeholder="{{ trans('labels.description') }}">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.image') }}
                                                (250 x 250) <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-end">
                                    <a href="{{ URL::to('admin/our-team') }}"
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
