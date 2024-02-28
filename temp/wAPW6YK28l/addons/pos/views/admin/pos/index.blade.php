@extends('admin.theme.default')
@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/admin/home') }}">{{ trans('labels.dashboard') }}</a>
            </li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('labels.pos') }}</a></li>
        </ol>
    </div>
</div>
<!-- row -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6 float-right my-4">
                <form action="{{ URL::to('admin/pos/items') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control rounded" name="search" @isset($_GET['search']) value="{{ $_GET['search'] }}" @endisset placeholder="{{ trans('labels.type_and_enter') }}" aria-label="{{ trans('labels.type_and_enter') }}" aria-describedby="basic-addon2">
                        <div class="input-group-append px-1">
                            <select class="form-control rounded" name="option">
                                <option value="" selected>{{ trans('labels.select') }}</option>
                                <option value="veg" @isset($_GET['option']) @if ($_GET['option'] == 'veg') selected @endif @endisset> {{ trans('labels.veg') }}</option>
                                <option value="nonveg" @isset($_GET['option']) @if ($_GET['option'] == 'nonveg') selected @endif @endisset> {{ trans('labels.nonveg') }}</option>
                            </select>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary rounded" type="submit">{{ trans('labels.fetch') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section class="item-section">
        @include('admin.pos.itemlisting')
    </section>
</div>


<div class="modal fade modalitemdetails" id="modalitemdetails" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header align-items-start">

            <span class="mr-1" id="item_type_image"></span>
            <div class="d-grid">
                <h4 class="modal-title fs-4 mr-1 item_name"></h4>
                <span class="text-muted item_price"></span>
            </div>

            <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
        </div>
        <div class="modal-body">
            <div class="row align-items-center">
                <div class="col-lg-10 col-md-10 col-sm-10 m-auto">
                    <div class="item-details">
                        <div class="item-varition-list mb-4" id="variation">
                            <h5 class="attribute"></h5>
                            <div class="mx-2 varition-listing">
                                {{-- <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                                    <label class="custom-control-label cursor-pointer" for="customRadioInline1">Toggle this custom radio</label>
                                </div> --}}
                            </div>
                        </div>
                        <div class="item-addons-list my-4" id="addons">
                            <h5>{{ trans('labels.addons') }}</h5>
                            <div class="mx-2 addons-listing">
                                {{-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="onion">
                                    <label class="form-check-label mr-3 cursor-pointer" for="onion">Onion</label>
                                    <span class="text-muted">$10</span>
                                </div> --}}
                            </div>
                        </div>

                        {{-- <br> item_id --}}
                        <input type="hidden" name="item_id" id="item_id">
                        {{-- <br> item_name --}}
                        <input type="hidden" name="item_name" id="item_name">
                        {{-- <br> item_type --}}
                        <input type="hidden" name="item_type" id="item_type">
                        {{-- <br> image_name --}}
                        <input type="hidden" name="image_name" id="image_name">
                        {{-- <br> tax --}}
                        <input type="hidden" name="tax" id="item_tax">
                        {{-- <br> item_price --}}
                        <input type="hidden" name="item_price" id="item_price">
                        {{-- <br> addonstotal --}}
                        <input type="hidden" name="addonstotal" id="addonstotal" value="0">
                        {{-- <br> subtotal --}}
                        <input type="hidden" name="subtotal" id="subtotal" value="0">

                        <div class="modal-footer px-0">
                            <button class="btn btn-block btn-success" onclick="addtocart('{{ URL::to('admin/pos/addtocart') }}')">
                                <div class="d-flex justify-content-between">
                                    <h5 class="subtotal m-0 text-white"></h5>
                                    <span class="text-white"><i class="ti-shopping-cart-full"></i> {{ trans('labels.add_to_cart') }}</span>
                                </div>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@if (session()->get('cartdata') != '' && count(session()->get('cartdata')) > 0)
<a href="{{ URL::to('/admin/pos/items/checkout') }}" class="btn-view-cart">{{ trans('labels.view_my_order') }} -
    {{ count(session()->get('cartdata')) }} </a>
@endif

@endsection

@section('script')
<script src="{{ url('resources/views/admin/pos/pos.js') }}"></script>
@endsection
