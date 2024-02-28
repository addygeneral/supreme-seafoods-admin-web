<div class="row page-titles mx-0 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            {{-- <li class="breadcrumb-item"><a href="{{ URL::to('/admin/home') }}">{{ trans('labels.dashboard') }}</a></li> --}}
            @if (request()->is('admin/bookings*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/bookings') }}">{{ trans('labels.bookings') }}</a></li>
            @endif
            @if (request()->is('admin/slider*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/slider') }}">{{ trans('labels.sliders') }}</a></li>
            @endif
            @if (request()->is('admin/category*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/category') }}">{{ trans('labels.categories') }}</a></li>
            @endif
            @if (request()->is('admin/sub-category*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/sub-category') }}">{{ trans('labels.subcategories') }}</a></li>
            @endif
            @if (request()->is('admin/addons*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/addons') }}">{{ trans('labels.addons') }}</a></li>
            @endif
            @if (request()->is('admin/banner*'))
                <li class="breadcrumb-item"><a href="{{ @$table_url }}">{{ @$title }}</a></li>
            @endif
            @if (request()->is('admin/zone*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/zone') }}">{{ trans('labels.zone') }}</a></li>
            @endif
            @if (request()->is('admin/promocode*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/promocode') }}">{{ trans('labels.promocodes') }}</a></li>
            @endif
            @if (request()->is('admin/time*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/time') }}">{{ trans('labels.working_hours') }}</a></li>
            @endif
            @if (request()->is('admin/payment*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/payment') }}">{{ trans('labels.payment_methods') }}</a></li>
            @endif
            @if (request()->is('admin/orders*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/orders') }}">{{ trans('labels.orders') }}</a></li>
            @endif
            @if (request()->is('admin/invoice*'))
                <li class="breadcrumb-item"><a href="{{ request()->url() }}">{{ trans('labels.invoice') }}</a></li>
            @endif
            @if (request()->is('admin/reviews*'))
                <li class="breadcrumb-item"><a href="{{ request()->url() }}">{{ trans('labels.reviews') }}</a></li>
            @endif
            @if (request()->is('admin/report*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/report') }}">{{ trans('labels.report') }}</a></li>
            @endif
            @if (request()->is('admin/notification*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/notification') }}">{{ trans('labels.notification') }}</a></li>
            @endif
            @if (request()->is('admin/contact*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/contact') }}">{{ trans('labels.inquiries') }}</a></li>
            @endif
            @if (request()->is('admin/driver*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/driver') }}">{{ trans('labels.drivers') }}</a></li>
            @endif
            @if (request()->is('admin/users*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/users') }}">{{ trans('labels.customers') }}</a></li>
            @endif
            @if (request()->is('admin/privacypolicy*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/privacypolicy') }}">{{ trans('labels.privacy_policy') }}</a></li>
            @endif
            @if (request()->is('admin/termscondition*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/termscondition') }}">{{ trans('labels.terms_conditions') }}</a></li>
            @endif
            @if (request()->is('admin/blogs*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/blogs') }}">{{ trans('labels.blogs') }}</a></li>
            @endif
            @if (request()->is('admin/our-team*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/our-team') }}">{{ trans('labels.our_team') }}</a></li>
            @endif
            @if (request()->is('admin/tutorial*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/tutorial') }}">{{ trans('labels.tutorial') }}</a></li>
            @endif
            @if (request()->is('admin/faq*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/faq') }}">{{ trans('labels.faq') }}</a></li>
            @endif
            @if (request()->is('admin/gallery*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/gallery') }}">{{ trans('labels.gallery') }}</a></li>
            @endif
            @if (request()->is('admin/settings*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/settings') }}">{{ trans('labels.general_settings') }}</a></li>
            @endif
            @if (request()->is('admin/roles*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/roles') }}">{{ trans('labels.employee_role') }}</a></li>
            @endif
            @if (request()->is('admin/employee*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/employee') }}">{{ trans('labels.employee') }}</a></li>
            @endif
            @if (request()->is('admin/item*'))
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/item') }}">{{ trans('labels.items') }}</a></li>
            @endif
            {{-- common-for-add-update-title --}}
            @if (substr(request()->url(), strrpos(request()->url(), '/' )+1) == "add")
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('labels.add_new') }}</a></li>
            @endif
            @if (request()->is('admin/slider-*') || request()->is('admin/category-*') || request()->is('admin/sub-category-*') || request()->is('admin/addons-*') || request()->is('admin/bannersection-*-*') || request()->is('admin/promocode-*') || request()->is('admin/driver-*') || request()->is('admin/users-*') || request()->is('admin/blogs-*') || request()->is('admin/our-team-*') || request()->is('admin/tutorial-*') || request()->is('admin/faq-*') || request()->is('admin/gallery-*') || request()->is('admin/roles-*') || request()->is('admin/employee-*') || request()->is('admin/item-*'))
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('labels.update') }}</a></li>
            @endif
        </ol>
        {{-- ADD BUTTON --}}
        @if (request()->is('admin/bannersection-1') || request()->is('admin/bannersection-2') || request()->is('admin/bannersection-3') || request()->is('admin/bannersection-4'))
            <a href="{{ @$add_url }}" class="btn btn-primary">{{ trans('labels.add_new') }}</a>
        @endif
        @if (request()->is('admin/slider') || request()->is('admin/addons') || request()->is('admin/category') || request()->is('admin/sub-category') || request()->is('admin/promocode') || request()->is('admin/driver') || request()->is('admin/blogs') || request()->is('admin/our-team') || request()->is('admin/tutorial') || request()->is('admin/faq') || request()->is('admin/gallery') || request()->is('admin/roles') || request()->is('admin/employee') || request()->is('admin/item') || request()->is('admin/notification') || request()->is('admin/zone'))
            <a href="{{ request()->url() . '/add' }}" class="btn btn-primary">{{ trans('labels.add_new') }}</a>
        @endif
    </div>
</div>