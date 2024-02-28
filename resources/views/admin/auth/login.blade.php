<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ @Helper::appdata()->title }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ Helper::image_path(@Helper::appdata()->favicon) }}">
    <!-- Favicon icon -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/fontawesome/all.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/toastr/toastr.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/responsive.css') }}"><!-- Responsive CSS -->
</head>

<body>
    @include('admin.theme.preloader')

    <div class="auth-main-content d-flex h-100 justify-content-center align-items-center">
        <div class="row justify-content-center align-items-center g-0 w-100">
            <div class="col-xl-4 col-lg-6 col-md-8 col-auto px-md-5 px-2">
                <div class="card box-shadow overflow-hidden border-0">
                    <div class="bg-primary-light">
                        <div class="row">
                            <div class="col-7 d-flex align-items-center"> 
                                <div class="text-primary p-4">
                                    <h4>{{ trans('labels.welcome_back') }}</h4>
                                    <p>{{ trans('labels.sign_to_continue') }}</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ Helper::image_path('authformbgimage.png') }}" class="img-fluid"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form class="my-3" method="POST" action="{{ URL::to('admin/check-login') }}">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    required="" autocomplete="email" autofocus
                                    placeholder="{{ trans('labels.email') }}"
                                    @if (env('Environment') == 'sendbox') value="admin@gmail.com" readonly="" @endif>
                                @error('email')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password"
                                    placeholder="{{ trans('labels.password') }}"
                                    @if (env('Environment') == 'sendbox') value="123456" readonly="" @endif>
                                @error('password')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <button class="btn btn-primary w-100 my-3"
                                type="submit">{{ trans('labels.signin') }}</button>
                        </form>
                        @if (env('Environment') == 'sendbox')
                            <div class="form-group mt-3">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Admin<br>admin@gmail.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info"
                                                    onclick="AdminFill()">{{ trans('labels.copy') }}</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Employee<br>employee@yopmail.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info"
                                                    onclick="VendorFill()">{{ trans('labels.copy') }}</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="mb-3 text-center">
                            <a href="{{ URL::to('admin/forgot-password') }}" class="text-muted fs-8 fw-500">
                                <i
                                    class="fa-solid fa-lock-keyhole mx-2 fs-7"></i>{{ trans('labels.forgot_password_q') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="circles-backgound-area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->
    <script>
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
        $(window).on("load", function() {
            "use strict";
            $('#preloader').fadeOut('slow')
        });

        function AdminFill() {
            $('#email').val('admin@gmail.com');
            $('#password').val('123456');
        }

        function VendorFill() {
            $('#email').val('employee@yopmail.com');
            $('#password').val('123456');
        }
    </script>
</body>

</html>
