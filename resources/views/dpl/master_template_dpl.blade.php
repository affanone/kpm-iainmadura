<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Aplikasi KPM {{ date('Y') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="http://iainmadura.ac.id/media/iainmadura.png" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- pace-progress -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/pace-progress/themes/black/pace-theme-flat-top.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
</head>


<body class="hold-transition sidebar-mini pace-loading-bar-danger layout-fixed">
    <div class="wrapper">
        @include('dpl.preloader_dpl')

        @include('dpl.navbar_dpl')

        @include('dpl.sidebar_dpl')

        @yield('content_dpl')

        @include('dpl.footer_dpl')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Moment JS -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <!-- pace-progress -->
    <script src="{{ asset('assets/plugins/pace-progress/pace.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

    @yield('script');

    <script>
        const activeurl = window.location;
        $('li', '#sideMenu')
            .filter(function() {
                return !!$(this).find('a[href="' + activeurl.origin + activeurl.pathname.replace(/\/$/,
                    "") + '"]').length;
            })
            .addClass('menu-open')
            .find('a:first').addClass('active');
    </script>

    <script>
        $('.modal').on('hidden.bs.modal', function(e) {
            const form = $(this).find('form');
            form[0].reset(); // Reset input from form
            form.validate().resetForm(); // Reset state after validated
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.is-valid').removeClass('is-valid');
        });
    </script>

    <script>
        function logoutConfirm() {
            Swal.fire({
                title: 'Apa Anda Yakin?',
                html: 'Anda akan keluar dari aplikasi',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Yakin!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/logout') }}",
                        success: function(res) {
                            Swal.fire(
                                'Berhasil',
                                'Anda telah keluar dari aplikasi',
                                'success'
                            ).then((result) => {
                                window.location.href = "{{ url('signin') }}";
                            });
                        },
                        error: function(res) {
                            Swal.fire(
                                'Gagal',
                                'Ada Kesalahan',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>
