@extends('admin.theme.default')
<link rel="stylesheet"
    href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/timepicker/jquery.timepicker.min.css') }}">
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ URL::to('admin/time/store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <label class="col-md-2 col-form-label"></label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.opening_time') }}</label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.break_start') }}</label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.break_end') }}</label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.closing_time') }}</label>
                                    <label
                                        class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.is_closed') }}</label>
                                </div>
                                @foreach ($gettime as $key => $time)
                                    <div class="row my-2">
                                        <label class="col-md-2 col-form-label"> <strong>
                                                {{ trans('labels.' . strtolower($time->day)) }} </strong> </label>
                                        <input type="hidden" name="day[]" value="{{ strtolower($time->day) }}">
                                        @if ($time->always_close == '2')
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.opening_time') }}</label>
                                                <input type="text" class="form-control h-fit-content timepicker {{ $errors->has('open_time.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.opening_time') }}" name="open_time[]" value="{{ $time->open_time }}" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.break_start') }}</label>
                                                <input type="text" class="form-control h-fit-content timepicker {{ $errors->has('break_start.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.break_start') }}" name="break_start[]" value="{{ $time->break_start }}" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.break_end') }}</label>
                                                <input type="text" class="form-control h-fit-content timepicker {{ $errors->has('break_end.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.break_end') }}" name="break_end[]" value="{{ $time->break_end }}" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.closing_time') }}</label>
                                                <input type="text" class="form-control h-fit-content timepicker {{ $errors->has('close_time.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.closing_time') }}" name="close_time[]" value="{{ $time->close_time }}" required>
                                            </div>
                                        @else
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.opening_time') }}</label>
                                                <input type="text" class="form-control h-fit-content {{ $errors->has('open_time.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.opening_time') }}" name="open_time[]" value="closed" readonly="" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.break_start') }}</label>
                                                <input type="text" class="form-control h-fit-content {{ $errors->has('break_start.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.break_start') }}" name="break_start[]" value="closed" readonly="" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.break_end') }}</label>
                                                <input type="text" class="form-control h-fit-content {{ $errors->has('break_end.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.break_end') }}" name="break_end[]" value="closed" readonly="" required>
                                            </div>
                                            <div class="form-group col-md-2 d-grid align-items-end">
                                                <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.closing_time') }}</label>
                                                <input type="text" class="form-control h-fit-content {{ $errors->has('close_time.' . $key) ? 'is-invalid' : '' }}" placeholder="{{ trans('labels.closing_time') }}" name="close_time[]" value="closed" readonly="" required>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-2">
                                            <label class="d-lg-none d-xl-none d-xxl-none">{{ trans('labels.is_closed') }}</label>
                                            <select class="form-select h-fit-content {{ $errors->has('always_close.' . $key) ? 'is-invalid' : '' }}" name="always_close[]" required>
                                                <option value="" selected disabled>{{ trans('labels.select') }}</option>
                                                <option value="1" @if ($time->always_close == '1') selected @endif>{{ trans('labels.yes') }}</option>
                                                <option value="2" @if ($time->always_close == '2') selected @endif>{{ trans('labels.no') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="form-group text-end">
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
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/timepicker/jquery.timepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            $(".timepicker").timepicker();
        });
    </script>
@endsection
