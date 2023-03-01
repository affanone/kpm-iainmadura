@extends('dpl.master_template')

@section('title', 'Data Nilai Peserta KPM')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Nilai Peserta KPM</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dpl.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Data Nilai Peserta KPM</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Peserta KPM</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <select class="custom-select" id="inputGroupSelect02"
                                            onchange="getFIlterPosko(this.value)">
                                            <option selected value="">All</option>
                                            @foreach ($posko as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama }}
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
                                {!! $datatable !!}
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

@section('style')
    <style>
        .form-nilai-kpm {
            width: 110px;
        }
    </style>
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
                url: "{{ route('dpl.nilai') }}",
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

        function getFIlterPosko(value) {
            filter.t = value;
            fetchData();
        }
    </script>
@endsection
