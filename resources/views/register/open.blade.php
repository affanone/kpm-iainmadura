<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pendaftaran | Aplikasi KPM {{ date('Y') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="http://iainmadura.ac.id/media/iainmadura.png" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}" />
    <style>
        .error {
            background-color: #ffe9eb !important;
            color: black !important;
        }

        .error .font-italic {
            color: #952828 !important;
        }

        .menu-utama a.active {
            color: var(--light) !important;
            background: var(--primary) !important;
            border-radius: 20px !important;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <img src="http://iainmadura.ac.id/media/iainmadura.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: 0.8" />
                    <span class="brand-text font-weight-light">Aplikasi KPM</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if ($step > 0)
                    <div class="collapse navbar-collapse order-3 menu-utama" id="navbarCollapse">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ route('reg_profil') }}"
                                    class="nav-link @if ($step == 1) active @endif">Data Diri</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reg_kpm') }}"
                                    class="nav-link @if ($step == 2) active @endif">Jenis KPM</a>
                                {{-- </li>
                            <li class="nav-item">
                                <a href="{{ route('reg_syarat') }}" class="nav-link">Persyaratan KPM</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reg_final') }}" class="nav-link">Finalisasi</a>
                            </li> --}}
                        </ul>
                    </div>
                @endif

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fas fa-user-cog"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="{{ asset('assets/dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                                        class="img-size-50 mr-3 img-circle" />
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Helap
                                        </h3>
                                        <p class="text-sm text-muted">
                                            <i class="fas fa-id-badge mr-1"></i> 123456789
                                        </p>
                                        <p class="text-sm text-muted">
                                            <i class="fas fa-graduation-cap"></i> Pendidikan Agama Islam
                                        </p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/logout" class="bg-danger dropdown-item dropdown-footer font-weight-bold">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
