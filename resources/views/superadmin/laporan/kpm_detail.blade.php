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
                        <h1>Detail KPM {{ $kpm->nama }} {{ $kpm->semester }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('laporan.kpm') }}">Laporan KPM</a></li>
                            <li class="breadcrumb-item active">KPM {{ $kpm->nama }} {{ $kpm->semester }}</li>
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
                                <h3 class="card-title">KPM {{ $kpm->nama }} {{ $kpm->semester }}</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <select class="custom-select" id="inputGroupSelect02"
                                            onchange="getFilterFakultas(this.value)">
                                            <option selected value="">All</option>
                                            @foreach ($fakultas as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (request()->fak == $item->id) selected @endif>
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-7 col-lg-6">
                                            <div class="card card-outline card-info">
                                                <div class="card-header">
                                                    <h3 class="card-title">Informasi Data</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-4">Total Pendaftar</div>
                                                        <div class="col-8">Total Plot</div>
                                                        <div class="col-4">Total Unplot</div>
                                                        <div class="col-8">Total Posko</div>
                                                        <div class="col-4"></div>
                                                        <div class="col-8"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="dataTableGenerate"
                                            class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
                                            <thead class="text-center">
                                                <tr>
                                                    <th width="1px">No</th>
                                                    <th>NIM</th>
                                                    <th>Nama</th>
                                                    <th>Fakultas</th>
                                                    <th>Prodi</th>
                                                    <th>KPM</th>
                                                    <th>Posko</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($mahasiswa as $i => $item)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $item->nim }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->prodi->fakultas->nama }}</td>
                                                        <td>{{ $item->prodi->sort }}</td>
                                                        <td>{{ $item->kpm }}</td>
                                                        <td>{{ $item->posko }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        $('#dataTableGenerate').DataTable();

        function getFilterFakultas(value) {
            url = addQueryParam(window.location.href, 'fak', value);
            window.location.href = url;
        }
    </script>
@endsection
