@extends('superadmin.master_template')

@section('title', 'Laporan KPM')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Laporan KPM</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Data Laporan KPM</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan KPM</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <select class="custom-select" id="inputGroupSelect02"
                                            onchange="getFilterTahun(this.value)">
                                            <option selected value="">All</option>
                                            @foreach ($tahun_akademik as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->semester . ' ' . $item->tahun . '/' . ($item->tahun + 1) }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="text" name="table_search" class="form-control float-right"
                                            id="filterCari" placeholder="Search" style="width: 100px;"
                                            onkeyup="if (event.keyCode === 13) getFilterCari()">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default" onclick="getFilterCari()">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div id="data">
                                {!! $datatable_info_kpm !!}
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </section>

    </div>
@endsection

@section('script')
    <script>
        var filter = {
            p: 1,
            q: '',
            t: ''
        }

        function fetchData() {
            $.ajax({
                url: "{{ route('laporan.kpm') }}",
                data: {
                    page: filter.p,
                    cari: filter.q,
                    tahun: filter.t
                },
                success: function(data) {
                    $('#data').html(data);
                }
            });
        }

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                filter.p = $(this).attr('href').split('page=')[1];
                fetchData();
            });
            $('table tr').addClass("text-center");
        });

        function getFilterCari() {
            filter.q = $('#filterCari').val();
            fetchData();
        }

        function getFilterTahun(value) {
            filter.t = value;
            fetchData();
        }
    </script>
@endsection
