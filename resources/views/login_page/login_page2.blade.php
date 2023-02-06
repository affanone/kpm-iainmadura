<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login - KPM {{ date('Y') }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/login_page2.css') }}">
</head>

<body>
    <div class="wrapper">
        <form class="login">
            <p class="title">Masuk Aplikasi</p>
            <input type="text" placeholder="NIM/NIP" autofocus />
            <i class="fas fa-id-badge"></i>
            <input type="password" placeholder="Password" />
            <i class="fas fa-key"></i>
            <a href="#">Forgot your password?</a>
            <button>
                <i class="spinner"></i>
                <span class="state">Masuk</span>
            </button>
        </form>
        <footer>Aplikasi KPM LP2M IAIN Madura &copy; {{ date('Y') }}. Develop By <a target="blank"
                href="#">TIPD
                IAIN
                Madura</a>
        </footer>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/login_page2.js') }}"></script>
</body>

</html>
