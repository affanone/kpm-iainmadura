@extends('master_template')

@section('title', 'Admin Fakultas')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Fakultas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Admin Fakultas</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTmbAdmFakultas"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Admin Fakultas</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblAdmFakultas" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Fakultas</th>
                                            <th>Tahun Akademik</th>
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
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <!-- /modal Tambah -->
        <div class="modal fade" id="modalTmbAdmFakultas" data-backdrop="static" data-keyboard="false"
            aria-labelledby="tmbAdmFakultas" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal" id="frmTmbAdmFakultas">
                        @csrf
                        <input class="d-none" type="text" name="id_admFakultas" id="id_admFakultas">
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title">Tambah/Edit Admin Fakultas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nama">Nama Pegawai</label>
                                            <select class="form-control select2" id="nama" name="nama"
                                                style="width: 100%;">
                                                <option value="">-- Pilih Pegawai --</option>
                                                @foreach ($pegawai as $dt_pegawai)
                                                    <option value="{{ $dt_pegawai->kode . '|' . $dt_pegawai->nama }}">
                                                        {{ $dt_pegawai->kode . ' - ' . $dt_pegawai->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="fakultas">Fakultas</label>
                                            <select class="form-control select2" id="fakultas" name="fakultas"
                                                style="width: 100%;">
                                                <option value="">-- Pilih Fakultas --</option>
                                                @foreach ($fakultas as $dt_fakultas)
                                                    <option value="{{ $dt_fakultas->id . '|' . $dt_fakultas->nama }}">
                                                        {{ $dt_fakultas->id . ' - ' . $dt_fakultas->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tahun">Tahun Akademik</label>
                                            <select class="form-control select2" id="tahun" name="tahun"
                                                style="width: 100%;">
                                                <option value="">-- Pilih Fakultas --</option>
                                                @foreach ($tahun_akademik as $dt_ta)
                                                    <option value="{{ $dt_ta->id }}">
                                                        {{ $dt_ta->tahun . ' - ' . ucwords(strtolower($dt_ta->semester)) . ' ' . ($dt_ta->status == 1 ? '(Aktif)' : '(Tidak Aktif)') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btnSmpAdmFakultas">Simpan</button>
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
        $('.select2').select2()

        const validFormAdmFakultas = $("#frmTmbAdmFakultas").validate({
            ignore: [],
            rules: {
                nama: {
                    required: true
                },
                fakultas: {
                    required: true
                },
                tahun: {
                    required: true
                }
            },
            messages: {
                nama: {
                    required: 'Harus dipilih'
                },
                fakultas: {
                    required: 'Harus dipilih'
                },
                tahun: {
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

                // disable button
                $('#btnSmpAdmFakultas').prop("disabled", true);
                // add spinner to button
                $('#btnSmpAdmFakultas').html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                );

                const id = $('#id_admFakultas').val();
                let method, url;
                if (id) {
                    method = "PUT";
                    url = "{{ route('admin_fakultas.update') }}";
                } else {
                    method = "POST";
                    url = "{{ route('admin_fakultas.post') }}";
                }
                $.ajax({
                    type: method,
                    url: url,
                    data: $('#frmTmbAdmFakultas').serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        document.getElementById('frmTmbAdmFakultas').reset();
                        $('#modalTmbAdmFakultas').modal('toggle');
                        $('#btnSmpAdmFakultas').prop("disabled", false);
                        $('#btnSmpAdmFakultas').html('Simpan');
                        $('#tblAdmFakultas').DataTable().ajax.reload(null,
                            false);
                        const msg = JSON.parse(JSON.stringify(data));
                        Swal.fire({
                            icon: msg.icon,
                            title: "Berhasil",
                            text: msg.message
                        });
                    },
                    error: function(data) {
                        $('#btnSmpAdmFakultas').prop("disabled", false);
                        $('#btnSmpAdmFakultas').html('Simpan');
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
        let tblAdmFakultas = $("#tblAdmFakultas").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin_fakultas.data') }}",
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
                    data: 'nama'
                },
                {
                    data: 'fakultas.nama'
                },
                {
                    data: 'tahun_akademik.tahun'
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
                    "targets": 1,
                    "className": "dt-body-left",
                    "visible": true
                },
                {
                    "targets": "_all",
                    "className": "dt-center cell-border"
                }
            ],
            "responsive": true,
            "autoWidth": true,
            "dom": '<"mb-3"B><"clearfix"<"float-left"l><"float-right"f>>t<"d-flex justify-content-between"ip>',
            "buttons": [{
                "extend": "excelHtml5",
                "text": "<i class='far fa-file-excel'></i> Download Excel",
                "className": "btn btn-sm btn-success"
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='far fa-file-pdf'></i> Download PDF",
                "className": "btn btn-sm btn-danger"
            }, {
                "extend": "print",
                "text": "<i class='fas fa-print'></i> Print",
                "className": "btn btn-sm btn-info"
            }]
        });
    </script>

    <script>
        function editAdmFakultas(id) {
            let url = "{{ route('admin_fakultas.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                dataType: "JSON"
            }).done((response) => {
                $('#id_admFakultas').val(response.id);
                $('#nama').val(response.user.username + '|' + response.nama).trigger('change');
                $('#fakultas').val(response.fakultas.id + '|' + response.fakultas.nama).trigger('change');
                $('#tahun').val(response.tahun_akademik_id).trigger('change');
                $('#modalTmbAdmFakultas').modal('show');
            });
        }
    </script>

    <script>
        function hapusAdmFakultas(id) {
            let url = "{{ route('admin_fakultas.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                dataType: "JSON"
            }).done((response) => {
                Swal.fire({
                    title: 'Apa Anda Yakin?',
                    html: `Anda akan menghapus Admin Fakultas : <span class="font-weight-bold font-italic"> ${response.nama}</span>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin_fakultas.delete') }}",
                            type: "DELETE",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": response.id
                            },
                            success: function(res) {
                                $('#tblAdmFakultas').DataTable().ajax.reload(null,
                                    false);
                                Swal.fire(
                                    res.title,
                                    res.message,
                                    res.icon
                                );
                            },
                            error: function(res) {
                                $('#tblAdmFakultas').DataTable().ajax.reload(null,
                                    false);
                                Swal.fire(
                                    'Gagal',
                                    'Ada Kesalahan',
                                    'error'
                                );
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire(
                            'Batal',
                            `Admin Fakultas : ${response.nama} tidak jadi dihapus`,
                            'info'
                        )
                    }
                });
            });
        };
    </script>
@endsection
