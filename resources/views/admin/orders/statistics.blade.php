<div class="row my-3">
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="{{ request()->is('admin/orders*') ? URL::to('/admin/orders') : 'javascript:void(0)' }}">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.total_orders') }}</p>
                            <h4>{{ count($getorders) }}</h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="{{ request()->is('admin/orders*') ? URL::to('/admin/orders?status=processing') : 'javascript:void(0)' }}">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-hourglass"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.processing') }}</p>
                            <h4>{{ $totalprocessing }}</h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="{{ request()->is('admin/orders*') ? URL::to('/admin/orders?status=completed') : 'javascript:void(0)' }}">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-check"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.completed') }}</p>
                            <h4>{{ $totalcompleted }}</h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @if (request()->is('admin/orders*'))
        
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <a href="{{ request()->is('admin/orders*') ? URL::to('/admin/orders?status=cancelled') : 'javascript:void(0)' }}">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-close"></i>
                        </span>
                        <span class="text-end">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.cancelled') }}</p>
                            <h4>{{ $totalcancelled }}</h4>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif
    @if (request()->is('admin/report*'))
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card border-0 box-shadow h-100">
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon">
                        <i class="fa-regular fa-money-bill-1-wave"></i>
                    </span>
                    <span class="text-end">
                        <p class="text-muted fw-medium mb-1">{{ trans('labels.revenue') }}</p>
                        <h4>{{ Helper::currency_format($totalearnings) }}</h4>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
