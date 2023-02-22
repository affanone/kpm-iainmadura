@extends('fakultas.master_template')

@section('title', 'Manajemen Data Posko')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Posko</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('fakultas.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Data Posko KPM</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPosko"><i
                            class="fas fa-plus-circle"></i> Tambah Posko</button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data DPL</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <select class="custom-select" id="inputGroupSelect02">
                                            <option selected>Choose...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>

                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search" style="width: 100px;">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
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

        <!-- /modal Tambah -->
        <div class="modal fade" id="modalTambahPosko" data-backdrop="static" data-keyboard="false"
            aria-labelledby="tmbAdmFakultas" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal" method="post" id="frmTmbAdmFakultas" action="#">
                        @csrf
                        <input class="d-none" type="text" name="id_admFakultas" id="id_admFakultas">
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title">Tambah/Edit Data Posko KPM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="tahun">Tahun Akademik</label>
                                            <input type="text" class="form-control" id="tahun" disabled
                                                value="{{ $tahun }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="fakultas">Fakultas</label>
                                            <input type="text" class="form-control" id="fakultas" disabled
                                                value="{{ $fakultas }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="nama" class="@error('nama') text-danger @enderror"> Nama
                                                Posko<strong class="text-danger">*</strong>
                                            </label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" placeholder="Nama Posko"
                                                value="{{ old('nama') }}">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="dpl">Dosen Pendamping Lapangan<strong
                                                    class="text-danger">*</strong></label>
                                            <div class="text-muted small">Data dosen dpl ditampilkan
                                                berdasarkan
                                                <strong>Homebase</strong> yang ada di simpadu
                                            </div>
                                            <select class="form-control select2" id="dpl" name="dpl"
                                                style="width: 100%;">
                                                <option value="" @if (!$edit) selected @endif
                                                    disabled> -- Pilih DPL -- </option>
                                                @foreach ($dpl as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if (old('dpl') == $item->id) selected @endif>
                                                        {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat Posko<strong class="text-danger">*</strong>
                                            </label>
                                            <textarea name="alamat" id="alamat" cols="3" class="form-control">{{ old('alamat') }}</textarea>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="deskripsi">Deksripsi Posko <span
                                                    class="text-muted">Opsional</span></label>
                                            <textarea name="deskripsi" id="deskripsi" cols="3" class="form-control">{{ old('deskripsi') }}</textarea>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btnSmpDPL">Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2()

        @if ($errors->any() || $edit)
            $('.modal').modal('show');
        @endif

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $.ajax({
                    url: "/fakultas/posko?page=" + page,
                    success: function(data) {
                        $('#data').html(data);
                    }
                });
            });
        });
    </script>
@endsection
