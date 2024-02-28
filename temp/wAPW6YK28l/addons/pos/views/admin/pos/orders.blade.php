@extends('admin.theme.default')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/admin/home') }}">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('labels.pos_orders') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ trans('labels.pos_orders') }}</h4>
                        <div class="table-responsive" id="table-display">
                            @include('admin.orders.orderstable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{url('resources/views/admin/orders/orders.js')}}"></script>
@endsection
