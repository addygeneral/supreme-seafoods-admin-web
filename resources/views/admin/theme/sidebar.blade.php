<!-- For Large Devices -->
<nav class="sidebar sidebar-lg">
    <div class="d-flex justify-content-start align-items-center mb-3 border-bottom">
        <div class="navbar-header-logo pb-2">
            <a class="navbar-brand" href="{{ URL::to('admin/home') }}">
                    <img class="img-resposive img-fluid" src="{{ Helper::image_path(@Helper::appdata()->logo) }}"
                        alt="logo" width="40px" height="auto">
                </a>
            <a href="{{ URL::to('admin/home') }}" class=" fs-4">
            @if (Auth::user()->type == 1)
                {{ trans('labels.admin_title') }}
            @elseif(Auth::user()->type == 4)
                {{ trans('labels.employee') }}
            @endif
            </a>
        </div>
    </div>
    @include('admin.theme.sidebarcontent')
</nav>
<!-- For Small Devices -->
<nav class="collapse collapse-horizontal sidebar sidebar-md" id="sidebarcollapse">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom">
        <a href="{{ URL::to('admin/home') }}" class=" fs-4">
        @if (Auth::user()->type == 1)
            {{ trans('labels.admin_title') }}
        @elseif(Auth::user()->type == 4)
            {{ trans('labels.employee') }}
        @endif
        </a>
        <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarcollapse" aria-expanded="false" aria-controls="sidebarcollapse"><i class="fa-light fa-xmark"></i></button>
    </div>
    @include('admin.theme.sidebarcontent')
</nav>