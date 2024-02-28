<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ @Helper::appdata()->title }} | {{ trans('labels.admin_title') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ Helper::image_path(@Helper::appdata()->favicon) }}">
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/bootstrap/bootstrap.min.css') }}"><!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/fontawesome/all.min.css') }}"><!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/toastr/toastr.min.css') }}"><!-- Toastr CSS -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/sweetalert/sweetalert2.min.css') }}"><!-- Sweetalert CSS -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/responsive.css') }}"><!-- Responsive CSS -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/datatables/dataTables.bootstrap5.min.css') }}"><!-- dataTables css -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/datatables/dataTables.bootstrap5.min.css') }}"><!-- dataTables css -->
    <link rel="stylesheet" href="{{url(env('ASSETSPATHURL').'admin-assets/assets/css/datatables/buttons.dataTables.min.css') }}"><!-- dataTables css -->
    @yield('styles')
</head>
<body>
    @include('admin.theme.preloader')
    <main>
        <div class="wrapper">
            @include('admin.theme.header')
            <div class="content-wrapper">
                @include('admin.theme.sidebar')
                <div class="main-content">
                    <div class="page-content">
                        @if (Helper::check_alert() == 0)
                            <div class="alert alert-danger text-center">
                                <a href="{{ URL::to('admin/settings') }}" class="text-dark"> <i class="fa fa-cog"></i> {{ trans('messages.settings_note') }}</a>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- Modal Change Password-->
            <div class="modal fade text-left" id="editprofilemodal" tabindex="-1" role="dialog" aria-labelledby="RditProduct" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title text-text-bold-600" id="RditProduct">{{ trans('labels.edit_profile') }}</label>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ URL::to('admin/edit-profile') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ trans('labels.name') }} </label>
                                        <div class="form-group">
                                            <input type="text" placeholder="{{ trans('labels.name') }}"
                                                class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label>{{ trans('labels.email') }} </label>
                                        <div class="form-group">
                                            <input type="email" placeholder="{{ trans('labels.email') }}"
                                                class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label>{{ trans('labels.mobile') }} </label>
                                        <div class="form-group">
                                            <input type="text" placeholder="{{ trans('labels.mobile') }}"
                                                class="form-control" name="mobile" id="mobile" value="{{ Auth::user()->mobile }}" required>
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>{{ trans('labels.image') }} </label>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="profile" accept=".jpg,.jpeg,.png">
                                            @error('profile') <span class="text-danger">{{ $message }}</span> <br> @enderror
                                            <img src="{{ Helper::image_path(Auth::user()->profile_image) }}" class="img-fluid rounded user-profile-image mt-1" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                                <input class="btn btn-primary" @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    value="{{ trans('labels.edit') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Change Password-->
            <div class="modal fade text-left" id="changepasswordmodal" tabindex="-1" role="dialog" aria-labelledby="RditProduct" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title text-text-bold-600" id="RditProduct">{{ trans('labels.change_password') }}</label>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ URL::to('admin/change-password') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>{{ trans('labels.old_password') }} </label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="{{ trans('labels.old_password') }}" value=" " required>
                                            @error('oldpassword')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label>{{ trans('labels.new_password') }} </label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="{{ trans('labels.new_password') }}" required>
                                            @error('newpassword')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <label>{{ trans('labels.confirm_password') }} </label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="{{ trans('labels.confirm_password') }}" required>
                                            @error('confirmpassword')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                                <input class="btn btn-primary" @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif value="{{ trans('labels.edit') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Modal: order-modal-->
            <div class="modal fade" id="order-modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-notify modal-info" role="document">
                    <div class="modal-content text-center">
                        <div class="modal-header d-flex justify-content-center">
                            <p class="heading">{{ trans('messages.be_up_to_date') }}</p>
                        </div>
                        <div class="modal-body"><i class="fa fa-bell fa-4x animated rotateIn mb-4"></i>
                            <p>{{ trans('messages.new_order_arrive') }}</p>
                        </div>
                        <div class="modal-footer flex-center">
                            <a role="button" class="btn btn-outline-secondary-modal waves-effect"
                                onClick="window.location.reload();"
                                data-bs-dismiss="modal">{{ trans('labels.okay') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--Modal: modalPush-->
            <!-- ASSIGN-DRIVER-MODAL-START -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="post" id="assign">
                            @csrf
                            <input type="hidden" name="driverurl" id="driverurl"
                                value="{{ URL::to('admin/orders/assign-driver') }}">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" id="order_id" name="order_id" readonly>
                                <div class="form-group">
                                    <label for="category_id"
                                        class="col-form-label">{{ trans('labels.order_number') }}</label>
                                    <input type="text" class="form-control" id="order_number" readonly="">
                                    <span class="id_error text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="category_id"
                                        class="col-form-label">{{ trans('messages.select_driver') }}
                                    </label>
                                    <select class="form-control" name="driver_id" id="driver_id"
                                        required="required">
                                        <option value="" selected>{{ trans('messages.select_driver') }}
                                        </option>
                                        @if (is_array(@$getdriver) || is_object(@$getdriver))
                                            @foreach (@$getdriver as $driver)
                                                <option value="{{ $driver->id }}">
                                                    {{ $driver->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="driver_error text-danger"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                    data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                                <button type="button" class="btn btn-primary"
                                    onclick="assigndriver()">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ASSIGN-DRIVER-MODAL-END -->
            <footer class="py-3 text-center bg-white fixed-bottom border-top">
                Copyrights @ 2021-22 &amp; {{ trans('labels.designed_developed_by') }} <a
                    href="https://urhitech.com/" target="_blank">{{ trans('labels.gravity_infotech') }}</a>
            </footer>
        </div>
    </main>
    @include('admin.theme.script')
    <script type="text/javascript">
        let are_you_sure = "{{ trans('messages.are_you_sure') }}";
        let yes = "{{ trans('messages.yes') }}";
        let no = "{{ trans('messages.no') }}";
        let wrong = "{{ trans('messages.wrong') }}";
        let cannot_delete = "{{ trans('messages.cannot_delete') }}";
        let last_image = "{{ trans('messages.last_image') }}";
        let record_safe = "{{ trans('messages.record_safe') }}";
        let select = "{{ trans('labels.select') }}";
        let variation = "{{ trans('labels.variation') }}";
        let enter_variation = "{{ trans('labels.variation') }}";
        let product_price = "{{ trans('labels.product_price') }}";
        let enter_product_price = "{{ trans('labels.product_price') }}";
        let sale_price = "{{ trans('labels.sale_price') }}";
        let enter_sale_price = "{{ trans('labels.sale_price') }}";
        function currency_format(price) {
            if ("{{ @Helper::appdata()->currency_position }}" == 1) {
                return "{{ @Helper::appdata()->currency }}" + parseFloat(price).toFixed(2);
            } else {
                return parseFloat(price).toFixed(2) + "{{ @Helper::appdata()->currency }}";
            }
        }
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
        // New Notification 
        var noticount = 0;
        (function noti() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('admin/getorder') }}",
                method: 'GET', //Get method,
                dataType: "json",
                success: function(response) {
                    noticount = localStorage.getItem("count");
                    if (response.count > 9) {
                        $('#notificationcount').text(response.count + "+");
                    } else {
                        $('#notificationcount').text(response.count);
                    }
                    if (response.count != 0) {
                        if (noticount != response.count) {
                            localStorage.setItem("count", response.count);
                            jQuery("#order-modal").modal('show');
                            var audio = new Audio("{{ url(env('ASSETSPATHURL'))}}/admin-assets/notification/"+response.noti);
                            audio.play();
                        }
                    } else {
                        localStorage.setItem("count", response.count);
                    }
                    setTimeout(noti, 5000);
                }
            });
        })();
    </script>
     <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/common.js') }}"></script><!-- Common JS -->
    @yield('script')
</body>
</html>