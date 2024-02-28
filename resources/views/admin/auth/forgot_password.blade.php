<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ @Helper::appdata()->title }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{Helper::image_path(@Helper::appdata()->favicon)}}"><!-- FAVICON ICON -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/bootstrap/bootstrap.min.css') }}"><!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/fontawesome/all.min.css') }}"><!-- FONTAWESOME CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/toastr/toastr.min.css') }}"><!-- FONTAWESOME CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/style.css') }}"><!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL').'admin-assets/assets/css/responsive.css') }}"><!-- RESPONSIVE CSS -->
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
                                    <h4>{{trans('labels.forgot_password_q')}}</h4>
                                </div>
                            </div>
                            <div class="col-5 align-self-end py-2">
                                <img src="{{Helper::image_path('authformbgimage.png')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form class="my-3" method="POST" action="{{ URL::to('admin/send-pass')}}">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required="" autocomplete="email" autofocus placeholder="{{trans('labels.email')}}" @if (env('Environment') == 'sendbox') value="admin@gmail.com" readonly="" @endif>
                                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <button class="btn btn-primary w-100 my-3" @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{trans('labels.send')}}</button>
                            <p class="fs-7 text-center">{{ trans('labels.already_account') }}
                                <a href="{{URL::to('admin')}}"
                                    class="text-primary fw-semibold">{{trans('labels.signin')}}</a>
                            </p>
                        </form>
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
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/jquery/jquery.min.js') }}"></script><!-- JQUERY JS -->
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP JS -->
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/toastr/toastr.min.js') }}"></script><!-- TOASTR JS -->
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        @if(Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if(Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
        $(window).on("load", function () {
            "use strict";
            $('#preloader').fadeOut('slow')
        });
        function myFunction() {
            "use strict";
            toastr.error("This operation was not performed due to demo mode");
        }
    </script>
</body>
</html>