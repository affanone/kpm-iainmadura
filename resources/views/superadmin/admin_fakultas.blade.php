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
                                                style="width: 100%;"></select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="kelamin">Jenis Kelamin</label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kelaminL"
                                                    name="kelamin" value="L" checked>
                                                <label for="kelaminL" class="custom-control-label">Laki-laki</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kelaminP"
                                                    name="kelamin" value="P">
                                                <label for="kelaminP" class="custom-control-label">Perempuan</label>
                                            </div>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="hp">No. HP</label>
                                            <input type="text" class="form-control" id="hp" name="hp"
                                                data-inputmask='"mask": "(99) 99-999-999-999"' data-mask>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" cols="3" class="form-control"></textarea>
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
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <!-- Memanggil data fakultas dan pegawai dari API -->
    <script>
        $(document).ready(() => {
            $.ajax({
                type: 'GET',
                url: "https://api.iainmadura.ac.id/api/pegawai",
                dataType: "json",
                success: function(response) {
                    const total = response.total;
                    $.ajax({
                        type: 'GET',
                        url: `https://api.iainmadura.ac.id/api/pegawai?limit=${total}`,
                        dataType: "json",
                        success: function(res) {
                            const data = res.data;
                            data.forEach((item) => {
                                // console.log(item);
                                var opt = new Option(item.kode + ' - ' +
                                    item.nama, item.kode);
                                $("#nama").append(opt);
                            });
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $('.select2').select2()
        $('[data-mask]').inputmask()

        const validFormDPL = $("#frmTmbDPL").validate({
            rules: {
                kelamin: {
                    required: true
                },
                hp: {
                    required: true
                },
                alamat: {
                    required: true
                }
            },
            messages: {
                kelamin: {
                    required: 'Harus dipilih'
                },
                hp: {
                    required: 'Harus diisi'
                },
                alamat: {
                    required: 'Harus diisi'
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
                $('#btnSmpDPL').prop("disabled", true);
                // add spinner to button
                $('#btnSmpDPL').html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                );

                const id = $('#id_dpl').val();
                let method, url;
                method = "PUT";
                url = "{{ route('dpl.update') }}";

                $.ajax({
                    type: method,
                    url: url,
                    data: $('#frmTmbDPL').serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        document.getElementById('frmTmbDPL').reset();
                        $('#modalTmbDPL').modal('toggle');
                        $('#btnSmpDPL').prop("disabled", false);
                        $('#btnSmpDPL').html('Simpan');
                        $('#tblDPL').DataTable().ajax.reload(null,
                            false);
                        const msg = JSON.parse(JSON.stringify(data));
                        Swal.fire({
                            icon: msg.icon,
                            title: "Berhasil",
                            text: msg.message
                        });
                    },
                    error: function(data) {
                        $('#btnSmpDPL').prop("disabled", false);
                        $('#btnSmpDPL').html('Simpan');
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
        let tblDPL = $("#tblDPL").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dpl.data') }}",
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
                    data: 'prodi'
                },
                {
                    data: 'hp'
                },
                {
                    data: 'alamat'
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
        function editDPL(id) {
            let url = "{{ route('dpl.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                dataType: "JSON"
            }).done((response) => {
                $('#id_dpl').val(response.id);
                $('#nama').val(response.nama);
                $('input[name="kelamin"][value="' + response.kelamin + '"]').prop('checked', true);
                $('#hp').val(response.hp);
                $('#alamat').val(response.alamat);
                $('#modalTmbDPL').modal('show');
            });
        }
    </script>

    <script>
        function hapusDPL(id) {
            let url = "{{ route('dpl.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                dataType: "JSON"
            }).done((response) => {
                Swal.fire({
                    title: 'Apa Anda Yakin?',
                    html: `Anda akan menghapus DPL : <span class="font-weight-bold font-italic"> ${response.nama}</span>`,
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
                            url: "{{ route('dpl.delete') }}",
                            type: "DELETE",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": response.id
                            },
                            success: function(res) {
                                $('#tblDPL').DataTable().ajax.reload(null,
                                    false);
                                Swal.fire(
                                    res.title,
                                    res.message,
                                    res.icon
                                );
                            },
                            error: function(res) {
                                $('#tblDPl').DataTable().ajax.reload(null,
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
                            `DPL : ${response.nama} tidak jadi dihapus`,
                            'info'
                        )
                    }
                });
            });
        };
    </script>
@endsection
