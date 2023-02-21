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
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblDPL" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Prodi</th>
                                            <th>No. HP</th>
                                            <th>Alamat</th>
                                            <th width="7%">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal" id="frmTmbAdmFakultas">
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nama">Nama Posko<strong class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="nama" name="nama"
                                                style="width: 100%;"></select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="deskripsi">Deksripsi <span
                                                    class="text-muted">Opsional</span></label>
                                            <textarea name="deskripsi" id="deskripsi" cols="3" class="form-control"></textarea>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="fakultas">Fakultas</label>
                                            <select class="form-control" id="fakultas" name="fakultas"
                                                style="width: 100%;"></select>
                                        </div>
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
@endsection
