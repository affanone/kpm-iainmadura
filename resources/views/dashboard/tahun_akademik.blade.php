@extends('master_template')

@section('title', 'Tahun Akademik KPM')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tahun Akademik KPM</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Tahun Akademik</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tmb-thn-akademik"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                    <button type="button" class="btn btn-info"><i class="fas fa-file-import"></i> Import Data</button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Tahun Akademik</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Tahun Akademik</th>
                                                <th>Semester</th>
                                                <th>Status</th>
                                                <th width="7%">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Superadmin</td>
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
                                        </tbody>
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

        <div class="modal fade" id="tmb-thn-akademik" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="tmbTahunAkademik" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title">Tambah Tahun Akademik</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-2 mr-3">
                                        <input type="text" class="form-control" id="tahun" name="tahun"
                                            autocomplete="off">
                                    </div>
                                    <label for="semester" class="col-sm-2 col-form-label">Semester</label>
                                    <div class="col-sm-2">
                                        <select class="form-control select2">
                                            <option selected="selected">-- Pilih salah satu --</option>
                                            <option>Ganjil</option>
                                            <option>Genap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-2">
                                        <input type="checkbox" name="status" id="status" data-on-text="Aktif"
                                            data-off-text="Tidak" checked data-off-color="danger" data-on-color="success">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-thn-akademik">Simpan</button>
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

@section('script')
    <script>
        $('#status').bootstrapSwitch({

        });
    </script>
@endsection
