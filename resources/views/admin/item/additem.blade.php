@extends('admin.theme.default')
@section('styles')
    <link rel="stylesheet"
        href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div id="privacy-policy-three" class="privacy-policy">
                            <form method="post" action="{{ URL::to('admin/item/store') }}" name="about" id="about"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cat_id"
                                                        class="col-form-label">{{ trans('labels.category') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <select name="cat_id" class="form-select" id="cat_id"
                                                        data-url="{{ URL::to('admin/item/subcategories') }}">
                                                        <option value="" selected>{{ trans('labels.select') }}
                                                        </option>
                                                        @foreach ($getcategory as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('cat_id') == $category->id ? 'selected' : '' }}
                                                                data-id="{{ $category->id }}">{{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('cat_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <span class="emsg text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="subcat_id"
                                                        class="col-form-label">{{ trans('labels.subcategory') }}</label>
                                                    <select name="subcat_id" class="form-select" id="subcat_id">
                                                        <option value="" selected>{{ trans('labels.select') }}
                                                        </option>
                                                    </select>
                                                    @error('subcat_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="item_name"
                                                value="{{ old('item_name') }}" placeholder="{{ trans('labels.name') }}">
                                            @error('item_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.addons') }}</label>
                                            <select class="form-control selectpicker" name="addons_id[]" multiple
                                                data-live-search="true">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getaddons as $key => $addons)
                                                    <option value="{{ $addons->id }}"
                                                        {{ !empty(old('addons_id')) && in_array($addons->id, old('addons_id')) ? 'selected' : '' }}>
                                                        {{ $addons->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="item_type" class="col-form-label">{{ trans('labels.item_type') }}
                                                <span class="text-danger">*</span> </label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0" type="radio" name="item_type"
                                                        id="veg" value="1" checked
                                                        @if (old('item_type') == 1) checked @endif>
                                                    <label class="form-check-label" for="veg"> <img
                                                            src="{{ Helper::image_path('veg.svg') }}" alt=""
                                                            srcset=""> {{ trans('labels.veg') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0" type="radio" name="item_type"
                                                        id="nonveg" value="2"
                                                        @if (old('item_type') == 2) checked @endif>
                                                    <label class="form-check-label" for="nonveg"> <img
                                                            src="{{ Helper::image_path('nonveg.svg') }}" alt=""
                                                            srcset=""> {{ trans('labels.nonveg') }}</label>
                                                </div>
                                                @error('item_type')
                                                    <br><span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.item_has_variation') }} <span
                                                    class="text-danger">*</span> </label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_variation" type="radio"
                                                        name="has_variation" id="no" value="2" checked
                                                        @if (old('has_variation') == 2) checked @endif>
                                                    <label class="form-check-label"
                                                        for="no">{{ trans('labels.no') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_variation" type="radio"
                                                        name="has_variation" id="yes" value="1"
                                                        @if (old('has_variation') == 1) checked @endif>
                                                    <label class="form-check-label"
                                                        for="yes">{{ trans('labels.yes') }}</label>
                                                </div>
                                                @error('has_variation')
                                                    <br><span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row dn @if ($errors->has('variants_name.*') || $errors->has('variants_price.*')) dn @endif @if (old('variants') == 2) d-flex @endif"
                                    id="price_row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="price"
                                                class="col-form-label">{{ trans('labels.product_price') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only" name="price"
                                                id="price" value="{{ old('price') }}"
                                                placeholder="{{ trans('labels.product_price') }}">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row panel-body dn @if ($errors->has('variation.*') || $errors->has('product_price.*') || old('has_variation') == 1) d-flex @endif"
                                    id="variations">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.attribute') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control attribute" name="attribute"
                                                value="{{ old('attribute') }}"
                                                placeholder="{{ trans('messages.enter_attribute') }}">
                                            @error('attribute')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.variation') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control variation" name="variation[]"
                                                placeholder="{{ trans('labels.variation') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.product_price') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control numbers_only product_price"
                                                name="product_price[]" placeholder="{{ trans('labels.product_price') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 d-none">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.sale_price') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control numbers_only sale_price"
                                                name="sale_price[]" placeholder="{{ trans('labels.sale_price') }}"
                                                value="0">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 d-flex align-items-end">
                                        <div class="form-group">
                                            <button class="btn btn-info" type="button"
                                                onclick="variation_fields('{{ trans('labels.variation') }}','{{ trans('labels.product_price') }}','{{ trans('labels.sale_price') }}');">
                                                <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="more_variation_fields"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.image') }} (512 x 512) <span
                                                    class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image[]" id="image"
                                                accept="image/*" multiple>
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="gallery"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{ trans('labels.preparation_time') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="preparation_time"
                                                        placeholder="{{ trans('labels.preparation_time') }}"
                                                        value="{{ old('preparation_time') }}">
                                                    @error('preparation_time')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tax"
                                                        class="col-form-label">{{ trans('labels.tax') }} (%)</label>
                                                    <input type="text" class="form-control" name="tax"
                                                        id="tax" value="0"
                                                        placeholder="{{ trans('labels.tax') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description"
                                                class="col-form-label">{{ trans('labels.description') }}</label>
                                            <textarea class="form-control" rows="5" name="description" id="description"
                                                placeholder="{{ trans('labels.description') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-end">
                                    <a href="{{ URL::to('admin/item') }}"
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
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/additem.js') }}"></script>
@endsection
