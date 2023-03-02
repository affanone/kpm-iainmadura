@extends('superadmin.master_template')

@section('title', 'Persyaratan KPM')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Persyaratan KPM</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Persyaratan</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah-syarat"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                    <button type="button" class="btn btn-info"><i class="fas fa-file-import"></i> Import Data</button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable with default features</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="7%">No</th>
                                                <th>Kategori</th>
                                                <th>Hak Akses</th>
                                                <th width="7%">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Superadmin</td>
                                                <td>_All</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning btn-sm"><i
                                                                class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-danger btn-sm"><i
                                                                class="fas fa-eraser"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori</th>
                                                <th>Hak Akses</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <div class="modal fade" id="tambah-syarat">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title">Tambah Persyaratan KPM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="jenisKpm" class="col-sm-2 col-form-label">Jenis KPM</label>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" style="width: 100%;">
                                            <option selected="selected">-- Pilih salah satu --</option>
                                            <option>KPM Institut</option>
                                            <option>KPM Fakultas</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control select2" style="width: 100%;">
                                            <option selected="selected">-- Pilih salah satu --</option>
                                            <option>KPM Reguler</option>
                                            <option>KPM Ramah Gender</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="syarat" class="col-sm-2 col-form-label">Persyaratan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="persyaratan" name="persyaratan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-syarat">Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /.content-wrapper -->
@endsection
