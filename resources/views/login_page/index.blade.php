<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Halaman Login - KPM IAIN Madura {{ date('Y') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="http://iainmadura.ac.id/media/iainmadura.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login/css/main.css') }}">
    <!--===============================================================================================-->
    <style>
        .toggle-password {
            float: right;
            color: #666666;
            margin-top: -34px;
            margin-right: 10px;
            position: relative;
            cursor: pointer;
            z-index: 2;
        }

        .error-login {
            background: #99333c;
            color: white;
            text-align: center;
            margin-bottom: 21px;
            padding: 5px 4px;
            border-radius: 6px;
            box-shadow: 0 0 3px #99333c;
        }
    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="http://iainmadura.ac.id/media/iainmadura.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" action="{{ route('login_auth') }}" method="post">
                    @csrf
                    <span class="login100-form-title">
                        Login Aplikasi KPM
                    </span>

                    @if ($errors->login->first())
                        <p class="error-login">{{ $errors->login->first() }}</p>
                    @endif

                    <div class="wrap-input100 validate-input" data-validate="NIM/NIP harus diisi">
                        <input class="input100" type="text" value="{{ old('id_login', '') }}" name="id_login"
                            placeholder="NIM/NIP" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password harus diisi">
                        <input class="input100" type="password" value="{{ old('password', '') }}" name="password"
                            id="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                        <span toggle="#password" class="fa fa-fw fa-eye toggle-password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            <span class="login_text"><i class="fa fa-sign-in" aria-hidden="true"></i>
                                &nbsp;Login
                            </span>
                            <span class="loading_text d-none"><i
                                    class="fa fa-spinner fa-spin"></i>&nbsp;Loading...</span>
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            <sup>*)</sup> Gunakan data login SIMPADU untuk masuk ke dalam aplikasi
                        </span>
                        {{-- <a class="txt2" href="#">
                            Username / Password?
                        </a> --}}
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="#">
                            {{-- Create your Account
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i> --}}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="{{ asset('login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('login/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('login/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('login/js/main.js') }}"></script>

    <script>
        $('input[name="password"]').on('keyup', () => {
            if ($('input[name="password"]').val()) {
                $('.toggle-password').removeClass('d-none');
            } else {
                $('.toggle-password').addClass('d-none');
            }
        });

        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($('.toggle-password').attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>

</body>

</html>
