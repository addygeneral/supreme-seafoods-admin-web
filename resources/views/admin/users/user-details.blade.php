@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row my-3">
        <div class="col-lg-3 col-md-6 col-6 d-flex my-2">
            <div class="card border-0 w-100">
                <div class="card-body">
                    <div class="text-center">
                        <img src='{{Helper::image_path($getusers->profile_image)}}' class="rounded-circle user-profile-image" alt="">
                        <h5 class="mt-3 mb-1">{{$getusers->name}}</h5>
                        <p class="m-0">{{$getusers->email}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-6 d-flex my-2">
            <div class="card border-0 w-100">
                <div class="card-body">
                    <div class="text-center">
                        <i class="fa-solid fa-cart-shopping h1"></i>
                        <h5 class="mt-3 mb-1">{{count($getorders)}}</h5>
                        <p class="m-0">{{trans('labels.orders')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-6 d-flex my-2">
            <div class="card border-0 w-100">
                <div class="card-body">
                    <div class="text-center">
                        <i class="fa-solid fa-share-from-square h1"></i>
                        <h5 class="mt-3 mb-1">
                            {{$getusers->referral_code == "" ? '-' : $getusers->referral_code}}
                        </h5>
                        <p class="m-0">{{trans('labels.referral_code')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-6 col-12 d-flex my-2">
            <div class="card border-0 w-100">
                <div class="card-body">
                    <div class="row d-flex">
                        <div class="col-md-6 mb-2">
                            <h4 class="card-title text-left">{{trans('labels.wallet')}}</h4><hr>
                            <div class="d-flex">
                                <div class="w-100 text-left w-50">
                                    <p class="text-muted mb-0">{{trans('labels.wallet_balance')}}</p>
                                    <h3 class="media-heading text-bold-400 my_wallet">{{Helper::currency_format(@$getusers->wallet)}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-left">
                            <h4 class="card-title text-left">{{trans('labels.manage_wallet')}}</h4><hr>
                            <input type="hidden" name="id" id="id" value="{{@$getusers->id}}">
                            <span class="text-danger dn" id="money_error"></span>
                            <input type="text" class="form-control mt-2 mb-2" name="money" placeholder="{{trans('labels.amount')}}" id="price">
                            <button class="btn btn-sm btn-success add" data-type="add" data-url="{{URL::to('admin/users/change-wallet')}}"> <i class="fa fa-arrow-up"></i> <small>{{trans('labels.add_money')}}</small></button>
                            <button class="btn btn-sm btn-warning deduct" data-type="deduct" data-url="{{URL::to('admin/users/change-wallet')}}"> <i class="fa fa-arrow-down"></i> <small>{{trans('labels.deduct_money')}}</small></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">{{ trans('labels.orders') }}</h4>
                    <div class="table-responsive" id="table-display">
                        @include('admin.orders.orderstable')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">{{ trans('labels.transactions') }}</h4>
                    <div class="table-responsive" id="table-display">
                        @include('admin.users.transactiontable')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/orders.js')}}"></script>
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/users.js')}}"></script>
@endsection
