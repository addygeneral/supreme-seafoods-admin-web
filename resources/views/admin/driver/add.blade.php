@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="form-validation">
                        <form action="{{URL::to('admin/driver/store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.name')}} <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="name" value="{{old('name')}}"
                                            id="name" placeholder="{{trans('labels.name')}}">
                                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.email')}} <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="email" value="{{old('email')}}"
                                            id="email" placeholder="{{trans('labels.email')}}">
                                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.mobile')}} <span
                                        class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="mobile" value="{{old('mobile')}}"
                                        id="mobile" placeholder="{{trans('labels.mobile')}}">
                                        @error('mobile') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.password')}} <span
                                                class="text-danger">*</span> </label>
                                        <input type="password" class="form-control" name="password"
                                            value="{{old('password')}}" id="password"
                                            placeholder="{{trans('labels.password')}}">
                                        @error('password') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.identity_type')}} <span
                                                class="text-danger">*</span> </label>
                                        <select id="identity_type" name="identity_type" class="form-select"
                                            aria-label="">
                                            <option value="" selected disabled>{{ trans('labels.select') }}</option>
                                            <option value="Passport" {{ old('identity_type')=="Passport" ? 'selected'
                                                : '' }}> {{ trans('labels.passport') }} </option>
                                            <option value="Driving License" {{ old('identity_type')=="Driving License"
                                                ? 'selected' : '' }}> {{ trans('labels.driving_license') }} </option>
                                            <option value="NID" {{ old('identity_type')=="NID" ? 'selected' : '' }}> {{
                                                trans('labels.nid') }} </option>
                                            <option value="Restaurant Id" {{ old('identity_type')=="Restaurant Id"
                                                ? 'selected' : '' }}> {{ trans('labels.restaurant_id') }} </option>
                                            <option value="Other" {{ old('identity_type')=="Other" ? 'selected' : '' }}>
                                                {{ trans('labels.other') }} </option>
                                        </select>
                                        @error('identity_type') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.identity_number')}} <span
                                                class="text-danger">*</span> </label>
                                        <input type="tel" class="form-control" name="identity_number"
                                            value="{{old('identity_number')}}" id="identity_number"
                                            placeholder="{{trans('labels.identity_number')}}">
                                        @error('identity_number') <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.identity_image')}} (420 x 525) <span
                                                class="text-danger">*</span> </label>
                                        <input type="file" class="form-control" name="image" value="{{old('image')}}"
                                            id="image">
                                        @error('image') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <a href="{{URL::to('admin/driver')}}"
                                    class="btn btn-outline-danger">{{trans('labels.cancel')}}</a>
                                <button class="btn btn-primary" @if (env('Environment')=='sendbox' ) type="button"
                                    onclick="myFunction()" @else type="submit" @endif>{{trans('labels.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection