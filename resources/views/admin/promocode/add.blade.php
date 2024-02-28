@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/promocode/store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.offer_name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="offer_name"
                                                value="{{ old('offer_name') }}" id="offer_name"
                                                placeholder="{{ trans('labels.offer_name') }}">
                                            @error('offer_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.offer_type') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <select class="form-select" name="offer_type">
                                                        <option value="" selected>{{ trans('labels.select') }}
                                                        </option>
                                                        <option value="1"
                                                            {{ old('offer_type') == '1' ? 'selected' : '' }}>
                                                            {{ trans('labels.fixed') }}</option>
                                                        <option value="2"
                                                            {{ old('offer_type') == '2' ? 'selected' : '' }}>
                                                            {{ trans('labels.percentage') }}</option>
                                                    </select>
                                                    @error('offer_type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.discount') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only"
                                                        name="offer_amount" value="{{ old('offer_amount') }}"
                                                        id="price" placeholder="{{ trans('labels.discount') }}">
                                                    @error('offer_amount')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.usage_type') }}
                                                <span class="text-danger">*</span> </label>
                                            <select class="form-select usage_type" name="usage_type">
                                                <option value="" selected>{{ trans('labels.select') }}
                                                </option>
                                                <option value="1" {{ old('usage_type') == '1' ? 'selected' : '' }}>
                                                    {{ trans('labels.once_time') }}</option>
                                                <option value="2" {{ old('usage_type') == '2' ? 'selected' : '' }}>
                                                    {{ trans('labels.multiple_times') }}</option>
                                            </select>
                                            @error('usage_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group" id="usage_limit_input">
                                            <label class="form-label">{{ trans('labels.usage_limit') }}<span
                                                    class="text-danger">
                                                    * </span></label>
                                            <input type="text" class="form-control" name="usage_limit"
                                                value="{{ old('usage_limit') }}"
                                                placeholder="{{ trans('labels.usage_limit') }}">
                                            @error('usage_limit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.offer_code') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" name="offer_code"
                                                        value="{{ old('offer_code') }}" id="offer_code"
                                                        placeholder="{{ trans('labels.offer_code') }}">
                                                    @error('offer_code')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.min_amount') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only"
                                                        name="min_amount" value="{{ old('min_amount') }}" id="min_amount"
                                                        placeholder="{{ trans('labels.min_amount') }}">
                                                    @error('min_amount')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.start_date') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="date" class="form-control" name="start_date"
                                                        value="{{ old('start_date') }}" id="start_date">
                                                    @error('start_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.end_date') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="date" class="form-control" name="expire_date"
                                                        value="{{ old('expire_date') }}" id="expire_date"
                                                        min="@php echo date('Y-m-d') @endphp" disabled>
                                                    @error('expire_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.description') }} <span
                                                    class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="description" rows="4" id="description"
                                                placeholder="{{ trans('labels.description') }}">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group text-end">
                                        <a href="{{ URL::to('admin/promocode') }}"
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
@section('script')
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/promocode.js') }}"></script>
@endsection
