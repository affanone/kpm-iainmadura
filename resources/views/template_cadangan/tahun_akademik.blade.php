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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tmbTahunAkademik"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
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
                                    <table id="tblThnAkademik" class="table table-bordered table-striped table-hover">
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

        <!-- /modal Tambah -->
        <div class="modal fade" id="tmbTahunAkademik" data-backdrop="static" data-keyboard="false"
            aria-labelledby="tmbTahunAkademik" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal" id="frmTmbThnAkademik">
                        @csrf
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title">Tambah Tahun Akademik</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tahun">Tahun</label>
                                            <input type="text" class="form-control" id="tahun" name="tahun"
                                                value="{{ old('tahun', date('Y')) }}" autocomplete="off">
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="semester">Semester</label>
                                            <select class="form-control" id="semester" name="semester">
                                                <option value="" selected="selected">-- Pilih Semester --</option>
                                                <option value="gasal">Gasal</option>
                                                <option value="genap">Genap</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <input class="form-control" type="checkbox" name="status" id="status"
                                                data-on-text="Aktif" data-off-text="Tidak" checked data-off-color="danger"
                                                data-on-color="success">
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btnSmpThnAkademik">Simpan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- /modal Tambah -->
        <div class="modal fade" id="modalEditThnAkademik" data-backdrop="static" data-keyboard="false"
            aria-labelledby="modalEditThnAkademik" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal" id="frmEditThnAkademik">
                        @method('PUT')
                        @csrf
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title">Edit Tahun Akademik</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tahun_edit">Tahun</label>
                                            <input type="text" class="form-control" id="tahun_edit" name="tahun_edit"
                                                autocomplete="off">
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="semester_edit">Semester</label>
                                            <select class="form-control" id="semester_edit" name="semester_edit">
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <input class="form-control" type="checkbox" name="status" id="status"
                                                data-on-text="Aktif" data-off-text="Tidak" checked
                                                data-off-color="danger" data-on-color="success">
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btnSmpThnAkademik">Simpan</button>
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
        $('#status').bootstrapSwitch();

        $("#frmTmbThnAkademik").validate({
            errorClass: 'error is-invalid',
            validClass: 'is-valid',
            rules: {
                tahun: {
                    required: true,
                    digits: true,
                    range: [new Date().getFullYear() - 5, new Date().getFullYear()]
                },
                semester: {
                    required: true
                }
            },
            messages: {
                tahun: {
                    required: 'Harus diisi',
                    digits: 'Hanya angka',
                    range: 'Isi diantara rentang tahun {0} dan {1}'
                },
                semester: {
                    required: 'Harus dipilih'
                }
            },
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            submitHandler: function(form, e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('tahun_akademik.post') }}",
                    data: $('#frmTmbThnAkademik').serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        document.getElementById('frmTmbThnAkademik').reset();
                        $('#tmbTahunAkademik').modal('toggle');
                        $('#tblThnAkademik').DataTable().ajax.reload(null,
                            false);
                        const msg = JSON.parse(JSON.stringify(data));
                        console.log(msg);
                        Swal.fire({
                            icon: msg.icon,
                            title: "Berhasil",
                            text: msg.message
                        });
                    },
                    error: function(data) {
                        const msg = JSON.parse(JSON.stringify(data));
                        Swal.fire({
                            icon: 'error',
                            title: "Gagal",
                            text: msg.responseJSON.message
                        });
                    }
                });
                return false;
            }
        });
    </script>

    <script>
        let tblThnAkademik = $("#tblThnAkademik").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('tahun_akademik.data') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                },
                {
                    data: 'tahun'
                },
                {
                    data: 'semester'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "order": [
                [1, 'asc']
            ],
            "columnDefs": [{
                "width": "30%",
                "targets": 2
            }, {
                "targets": "_all",
                "className": "text-center",
                "visible": true
            }],
            "responsive": true
        });
    </script>

    <script>
        function editThnAkademik(id) {
            let url = '{{ route('tahun_akademik.edit', ':id') }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                dataType: "JSON"
            }).done((response) => {
                const smt = {
                    "gasal": "Gasal",
                    "genap": "Genap"
                };

                $('#id_edit').val(response.id);
                $('#tahun_edit').val(response.tahun);

                $('#semester_edit').append(`<option value="">-- Pilih Semester --</option>`);
                for (const key in smt) {
                    const selected = response.semester.toLowerCase() == key ? 'selected' : '';
                    $('#semester_edit').append(`<option value="${key}" ${selected}>${smt[key]}</option>`);
                }

                $('#status_edit').val(response.status);
                $('#modalEditThnAkademik').modal('show');
            });
        }
    </script>
@endsection
