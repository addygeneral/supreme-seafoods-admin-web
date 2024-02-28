<header class="page-topbar">
    <div class="navbar-header">
        <button class="navbar-toggler d-lg-none d-md-block px-4" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarcollapse" aria-expanded="false" aria-controls="sidebarcollapse">
            <i class="fa-regular fa-bars fs-4"></i>
        </button>
        <div class="px-3 d-flex align-items-center">
            @if (Auth::user()->type == 1)
            @if (Helper::check_restaurant_closed() == 1)
                @php
                    $tooltiptitle = trans('messages.online_note');
                @endphp
                <input id="open-close-switch" type="checkbox" class="checkbox-switch" name="open-close" value="1" checked @if (env('Environment') == 'sendbox') onclick="myFunction()" disabled @else onclick="changeStatus(2,'{{ URL::to('admin/change-status') }}')" @endif>
            @else
                @php
                    $tooltiptitle = trans('messages.offline_note');
                @endphp
                <input id="open-close-switch" type="checkbox" class="checkbox-switch" name="open-close" value="" @if (env('Environment') == 'sendbox') onclick="myFunction()" disabled @else onclick="changeStatus(1,'{{ URL::to('admin/change-status') }}')" @endif>
            @endif
            <label for="open-close-switch" class="switch me-3" data-bs-toggle="tooltip" title="{{ $tooltiptitle }}" >
                <span class="switch__circle"><span class="switch__circle-inner"></span></span>
                <span class="switch__left ps-2">{{ trans('labels.off') }}</span>
                <span class="switch__right pe-2">{{ trans('labels.on') }}</span>
            </label>
            @endif
            <div class="dropwdown d-inline-block">
                <button class="btn header-item" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{Helper::image_path(Auth::user()->profile_image)}}">
                    <span class="d-none d-xxl-inline-block d-xl-inline-block ms-1">{{Auth::user()->name}}</span>
                    <i class="fa-regular fa-angle-down d-none d-xxl-inline-block d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu box-shadow">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editprofilemodal"><i class="fa-regular fa-user mx-2"></i>{{ trans('labels.edit_profile') }} </a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#changepasswordmodal"><i class="fa-regular fa-key mx-2"></i>{{ trans('labels.change_password') }} </a>
                    <a class="dropdown-item d-flex align-items-center" onclick="logout('{{ URL::to('/admin/logout') }}')" ><i class="fa-regular fa-arrow-right-from-bracket mx-2"></i>{{ trans('labels.logout') }} </a>
                </div>
            </div>
        </div>
    </div>
</header>