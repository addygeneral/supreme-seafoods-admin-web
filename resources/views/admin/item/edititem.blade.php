@extends('admin.theme.default')
@section('styles')
    <link rel="stylesheet"
        href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card border-0">
                    <div class="card-body">
                        <div id="privacy-policy-three" class="privacy-policy">
                            <form method="post" action="{{ URL::to('admin/item/update') }}" name="about" id="about"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ $getitem->id }}">
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
                                                                {{ $getitem->cat_id == $category->id ? 'selected' : '' }}
                                                                data-id="{{ $category->id }}">{{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                        @error('get_cat_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="subcat_id"
                                                        class="col-form-label">{{ trans('labels.subcategory') }}</label>
                                                    <select name="subcat_id" class="form-select" id="subcat_id">
                                                        <option value="" selected>{{ trans('labels.select') }}
                                                        </option>
                                                        @foreach ($getsubcategory as $subcatdata)
                                                            <option value="{{ $subcatdata->id }}"
                                                                {{ $getitem->subcat_id == $subcatdata->id ? 'selected' : '' }}>
                                                                {{ $subcatdata->subcategory_name }}</option>
                                                        @endforeach
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
                                            <label for="getitem_name" class="col-form-label">{{ trans('labels.name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" id="getitem_name" name="item_name"
                                                placeholder="{{ trans('labels.name') }}"
                                                value="{{ $getitem->item_name }}">
                                            @error('getitem_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="getaddons_id"
                                                class="col-form-label">{{ trans('labels.addons') }}</label>
                                            <?php $selected = explode(',', $getitem->addons_id); ?>
                                            <select name="addons_id[]" class="form-control selectpicker" multiple
                                                data-live-search="true" id="getaddons_id">
                                                @foreach ($getaddons as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ in_array($supplier->id, $selected) ? 'selected' : '' }}>
                                                        {{ $supplier->name }}</option>
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
                                                        id="veg" value="1"
                                                        @if ($getitem->item_type == 1) checked @endif>
                                                    <label class="form-check-label"
                                                        for="veg">{{ trans('labels.veg') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0" type="radio" name="item_type"
                                                        id="nonveg" value="2"
                                                        @if ($getitem->item_type == 2) checked @endif>
                                                    <label class="form-check-label"
                                                        for="nonveg">{{ trans('labels.nonveg') }}</label>
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
                                            <label for="has_variation"
                                                class="col-form-label">{{ trans('labels.item_has_variation') }} <span
                                                    class="text-danger">*</span> </label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_variation" type="radio"
                                                        name="has_variation" id="no" value="2"
                                                        @if ($getitem->has_variation == 2) checked @endif>
                                                    <label class="form-check-label"
                                                        for="no">{{ trans('labels.no') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_variation" type="radio"
                                                        name="has_variation" id="yes" value="1"
                                                        @if ($getitem->has_variation == 1) checked @endif>
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
                                <div class="row @if ($getitem->has_variation == 1) dn @endif" id="price_row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="price"
                                                class="col-form-label">{{ trans('labels.product_price') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only" name="price"
                                                id="price" placeholder="{{ trans('labels.product_price') }}"
                                                value="{{ $getitem->price }}">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="@if ($getitem->has_variation == 2) dn @endif" id="variations">
                                    <div class="col-md-12 px-0">
                                        <div class="form-group">
                                            <label for="attribute" class="col-form-label">{{ trans('labels.attribute') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control attribute" name="attribute"
                                                id="attribute" placeholder="{{ trans('messages.enter_attribute') }}"
                                                value="{{ $getitem->attribute }}">
                                            @error('attribute')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @foreach ($getvariation as $ky => $variation)
                                        <div class="row panel-body" id="del-{{ $variation->id }}">
                                            <input type="hidden" class="form-control" id="variation_id"
                                                name="variation_id[{{ $ky }}]" value="{{ $variation->id }}">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="variation"
                                                        class="col-form-label">{{ trans('labels.variation') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control variation"
                                                        name="variation[{{ $ky }}]" id="variation"
                                                        placeholder="{{ trans('labels.variation') }}" required=""
                                                        value="{{ $variation->variation }}">
                                                    @if ($errors->has('variation.' . $ky))
                                                        <span
                                                            class="text-danger">{{ $errors->first('variation.' . $ky) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="product_price"
                                                        class="col-form-label">{{ trans('labels.product_price') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only product_price"
                                                        id="product_price" name="product_price[{{ $ky }}]"
                                                        placeholder="{{ trans('labels.product_price') }}" required=""
                                                        value="{{ $variation->product_price }}">
                                                    @if ($errors->has('product_price.' . $ky))
                                                        <span
                                                            class="text-danger">{{ $errors->first('product_price.' . $ky) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-4 d-none">
                                                <div class="form-group">
                                                    <label for="sale_price"
                                                        class="col-form-label">{{ trans('labels.sale_price') }} <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control numbers_only sale_price"
                                                        id="sale_price" name="sale_price[{{ $ky }}]"
                                                        placeholder="{{ trans('labels.sale_price') }}" required=""
                                                        value="{{ $variation->sale_price }}">
                                                    @if ($errors->has('sale_price.' . $ky))
                                                        <span
                                                            class="text-danger">{{ $errors->first('sale_price.' . $ky) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-1 d-flex align-items-end">
                                                <div class="form-group">
                                                    <button class="btn btn-danger" type="button"
                                                        onclick="DeleteVariation('{{ $variation->id }}','{{ $getitem->id }}','{{ URL::to('admin/item/deletevariation') }}')">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $currentdata[] = [
                                            'currentkey' => $ky,
                                        ];
                                        ?>
                                    @endforeach
                                </div>
                                <p id="counter" style="display: none;">
                                    @if ($getitem->has_variation == 1)
                                        {{ count(array_column(@$currentdata, 'currentkey')) - 1 }}
                                    @endif
                                </p>
                                <div id="edititem_fields"></div>
                                <button
                                    class="btn btn-success btn-add-variations @if ($getitem->has_variation == 2) dn @endif"
                                    type="button"
                                    onclick="edititem_fields('{{ trans('labels.variation') }}','{{ trans('labels.product_price') }}','{{ trans('labels.sale_price') }}');">
                                    {{ trans('labels.add_varation') }} <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="preparation_time"
                                                        class="col-form-label">{{ trans('labels.preparation_time') }}
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" name="preparation_time"
                                                        id="preparation_time" value="{{ $getitem->preparation_time }}"
                                                        placeholder="{{ trans('labels.preparation_time') }}">
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
                                                        id="tax" value="{{ $getitem->tax }}"
                                                        placeholder="{{ trans('labels.tax') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description"
                                                class="col-form-label">{{ trans('labels.description') }}</label>
                                            <textarea class="form-control" rows="5" name="description" id="description"
                                                placeholder="{{ trans('labels.description') }}">{{ $getitem->item_description }}</textarea>
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
            <div class="col-12">
                <button type="button" class="btn btn-primary mb-3 float-end" data-bs-toggle="modal"
                    data-bs-target="#AddProduct" data-whatever="@addProduct">{{ trans('labels.add_image') }}</button>
            </div>
            <div class="col-12">
                <div class="row">
                    @foreach ($getitemimages as $itemimage)
                        <div class="col-lg-2 col-md-4 col-sm-6 my-card dataid{{ $itemimage->id }}" id="table-image">
                            <img class="img-fluid rounded edit-item-image"
                                src='{{ Helper::image_path($itemimage->image) }}'>
                            <div class="actioncenter justify-content-center">
                                <a href="javascript:void(0)" class="btn btn-sm btn-info mx-1"
                                    onClick="updateItemImage('{{ $itemimage->id }}','{{ URL::to('admin/item/showimage') }}')"><i
                                        class="fa-solid fa-pen-to-square" aria-hidden="true"></i> </a>
                                @if (count($getitemimages) > 1)
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger mx-1"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else onClick="deleteItemImage('{{ $itemimage->id }}','{{ $itemimage->item_id }}','{{ URL::to('admin/item/destroyimage') }}')" @endif><i
                                            class="fa fa-trash" aria-hidden="true"></i> </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Images -->
    <div class="modal fade" id="EditImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" name="editimg" class="editimg" id="editimg" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="updateimageurl" value="{{ URL::to('admin/item/updateimage') }}">
                <input type="hidden" id="idd" name="id">
                <input type="hidden" class="form-control" id="old_img" name="old_img">
                <input type="hidden" name="removeimg" id="removeimg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabeledit">{{ trans('labels.images') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <span id="emsg"></span>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ trans('labels.images') }} (500 x 250) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>
                        <div class="galleryim"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <button class="btn btn-primary"
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Item Image -->
    <div class="modal fade" id="AddProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" name="addproduct" class="addproduct" id="addproduct" enctype="multipart/form-data">
                <span id="msg"></span>
                <input type="hidden" id="storeimagesurl" value="{{ URL::to('admin/item/storeimages') }}">
                <input type="hidden" name="itemid" id="itemid" value="{{ request()->route('id') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('labels.images') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <span id="iiemsg"></span>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('labels.images') }} (500 x 250) <span
                                    class="text-danger">*</span></label>
                            <input type="file" multiple="true" class="form-control" name="file[]" id="file"
                                accept="image/*" required="">
                        </div>
                        <div class="gallery"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <button class="btn btn-primary"
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/additem.js') }}"></script>
@endsection
