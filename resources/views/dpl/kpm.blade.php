@extends('dpl.master_template_dpl')

@section('title', 'Data Posko')

@section('content_dpl')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Posko KPM</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dpl.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Data Posko KPM</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Posko KPM</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <select class="custom-select" id="inputGroupSelect02"
                                            onchange="getFilterTahun(this.value)">
                                            <option selected value="">All</option>
                                            @foreach ($tahun_akademiks as $item)
                                                <option value="{{ $item->tahun_akademik->id }}">
                                                    {{ $item->tahun_akademik->semester . ' ' . $item->tahun_akademik->tahun . '/' . ($item->tahun_akademik->tahun + 1) }}
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
