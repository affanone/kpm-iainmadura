@extends('dpl.master_template_dpl')

@section('title', 'Detail Posko ' . $posko->nama)

@section('content_dpl')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Posko {{ $posko->nama }}</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dpl.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dpl.kpm') }}">Data Posko KPM</a></li>
                            <li class="breadcrumb-item active">Posko {{ $posko->nama }}</li>
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
                    <div class="col-12 col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h3 class="card-title font-weight-bold">Detail Posko</h3>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="text-muted small">Nama Posko</div>
                                        <div>{{ $posko->nama }}</div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="text-muted small">Tahun</div>
                                        <div>{{ $posko->tahun_akademik->tahun }}</div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="text-muted small">DPL</div>
                                        <div>{{ $posko->dpl->nama }}</div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="text-muted small">Alamat Posko</div>
                                        <div>{{ $posko->alamat }}</div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="text-muted small">Jumlah Peserta</div>
                                        <div>{{ count($posko->posko_pendaftaran) }} Mhs</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 col-xl-9">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h3 class="card-title font-weight-bold">Peserta Pokso</h3>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Prodi</th>
                                            <th>Alamat</th>
                                            <th>No. HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posko->posko_pendaftaran as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $item->pendaftaran->mahasiswa->nim }}</td>
                                                <td>{{ $item->pendaftaran->mahasiswa->nama }}</td>
                                                <td>{{ $item->pendaftaran->mahasiswa->prodi->sort }}</td>
                                                <td>{{ $item->pendaftaran->mahasiswa->alamat }}</td>
                                                <td>{{ $item->pendaftaran->mahasiswa->hp }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
