<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admins/assets/images/image.png') }} ">
    <title>Đăng nhập Admin | VNvivu</title>
    <link href="{{ asset('admins/dist/css/style.min.css') }}  " rel="stylesheet">
</head>

<body>
<div class="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url({{ asset('admins/assets/images/big/image-bg.png') }}) no-repeat center center;">
        <div class="auth-box" style="border-radius: 25px;">
            <div id="loginform" >
                <div class="logo">
                    <span class="db"><img src="{{ asset('admins/assets/images/image.png') }}" alt="logo"/></span>
                    <h5 class="font-medium m-b-30" style="font-size: 26px;">Đăng nhập</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal m-t-20" id="loginform" method="POST"
                              action="{{ route('admin.login.post') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" name="email" placeholder="Email"
                                       aria-label="Email" aria-describedby="basic-addon1" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <div class="col-12 ">
                                <p class="text-danger">{{ $message }}</p>
                            </div>
                            @enderror
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" class="form-control form-control-lg" name="password"
                                       placeholder="Mật khẩu" aria-label="Password" aria-describedby="basic-addon1" }}>
                            </div>
                            @error('password')
                            <div class=" col-12 ">
                                <p class="text-danger">{{ $message }}</p>
                            </div>
                            @enderror

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        {{-- <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Lưu tài khoản</label> --}}
                                        {{-- <a href="{{ route('admin.password.request') }}" id="to-recover"
                                           class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> Quên tài
                                            khoản?</a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                @error('login')
                                <div class="col-12 text-left">
                                    <p class="text-danger">{{ $message }}</p>
                                </div>
                                @enderror
                                <div class="col-xs-12 p-b-20">
                                    <button class="btn btn-block btn-lg btn-info" type="submit">Log In</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                                    <div class="social">
                                        {{--                                        <a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="" data-original-title="Login with Facebook"> <i aria-hidden="true" class="fab  fa-facebook"></i> </a>--}}
                                        {{--                                        <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="" data-original-title="Login with Google"> <i aria-hidden="true" class="fab  fa-google-plus"></i> </a>--}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- All Required js -->
<!-- ============================================================== -->
<script src="{{ asset('admins/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('admins/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('admins/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- ============================================================== -->
<!-- This page plugin js -->
<!-- ============================================================== -->
<script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>
</body>

</html>
