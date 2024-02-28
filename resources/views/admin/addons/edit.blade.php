@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="form-validation">
                        <form action="{{URL::to('admin/addons/update-'.$addonsdata->id)}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.name')}} <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="name" id="addons_name"
                                            placeholder="{{trans('labels.name')}}" value="{{$addonsdata->name}}">
                                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{trans('labels.type')}} <span
                                                class="text-danger">*</span> </label>
                                        <label class="radio-inline me-3"><input type="radio" name="type" value="1"
                                                onclick="get_price(this)" {{$addonsdata->price<=0 ? 'checked' : '' }}>
                                                {{trans('labels.free')}}</label>
                                        <label class="radio-inline me-3"><input type="radio" name="type" value="2"
                                                onclick="get_price(this)" {{$addonsdata->price>0 ? 'checked' : ''}}>
                                            {{trans('labels.paid')}}</label>
                                        @error('type') <br><span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group @if($addonsdata->price<=0) dn @endif" id="price_row">
                                        <label class="col-form-label" for="">{{trans('labels.price')}} <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="price" id="price"
                                            placeholder="{{trans('labels.price')}}" value="{{$addonsdata->price}}">
                                        @error('price') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <a href="{{URL::to('admin/addons')}}"
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
@section('script')
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/addons.js')}}"></script>
@endsection