@extends('master_template')

@section('title', 'Jenis KPM')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jenis KPM</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Jenis KPM</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTmbJenisKPM"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Jenis KPM</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblJenisKPM" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Tahun Akademik</th>
                                            <th>Jenis KPM</th>
                                            <th>Deskripsi</th>
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
        <div class="modal fade" id="modalTmbJenisKPM" data-backdrop="static" data-keyboard="false"
            aria-labelledby="modalTmbJenisKPM" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- form start -->
                    <form class="form-horizontal" id="frmTmbJenisKPM">
                        @csrf
                        <input class="d-none" type="text" name="id_jenisKPM" id="id_jenisKPM">
                        <div class="modal-header bg-secondary">
                            <h5 class="modal-title">Tambah Jenis KPM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tahun">Tahun Akademik</label>
                                            <select class="form-control" id="tahun" name="tahun">
                                                <option value="">-- Pilih Tahun Akademik --</option>
                                                @foreach ($ta as $dt_ta)
                                                    <option value="{{ $dt_ta->id }}">
                                                        {{ $dt_ta->tahun . ' - ' . ucwords(strtolower($dt_ta->semester)) . ' ' . ($dt_ta->status == 1 ? '(Aktif)' : '(Tidak Aktif)') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="jenis">Jenis KPM</label>
                                            <input type="text" class="form-control" id="jenis" name="jenis"
                                                autocomplete="off">
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi KPM</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"
                                                placeholder="Ketikan deskripsi disini ..."></textarea>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btnSmpJenisKPM">Simpan</button>
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
        const validFormJenisKPM = $("#frmTmbJenisKPM").validate({
            rules: {
                tahun: {
                    required: true
                },
                jenis: {
                    required: true
                }
            },
            messages: {
                tahun: {
                    required: 'Harus dipilih'
                },
                jenis: {
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
                $('#btnSmpJenisKPM').prop("disabled", true);
                // add spinner to button
                $('#btnSmpJenisKPM').html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                );
                
                const id = $('#id_jenisKPM').val();
                let method, url;
                if (id) {
                    method = "PUT";
                    url = "{{ route('jenis_kpm.update') }}";
                } else {
                    method = "POST";
                    url = "{{ route('jenis_kpm.post') }}";
                }

                $.ajax({
                    type: method,
                    url: url,
                    data: $('#frmTmbJenisKPM').serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        document.getElementById('frmTmbJenisKPM').reset();
                        $('#modalTmbJenisKPM').modal('toggle');
                        $('#btnSmpJenisKPM').prop("disabled", false);
                        $('#btnSmpJenisKPM').html('Simpan');
                        $('#tblJenisKPM').DataTable().ajax.reload(null,
                            false);
                        const msg = JSON.parse(JSON.stringify(data));
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
        let tblJenisKPM = $("#tblJenisKPM").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('jenis_kpm.data') }}",
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
                    data: 'tahun_akademik.tahun'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "order": [
                [1, 'desc']
            ],
            "columnDefs": [{
                "targets": "_all",
                "className": "dt-center cell-border",
                "visible": true
            }],
            "responsive": true,
            "autoWidth": true,
            "fixedColumns": true
        });
    </script>

    <script>
        function editJenisKPM(id) {
            let url = '{{ route('jenis_kpm.edit', ':id') }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                dataType: "JSON"
            }).done((response) => {
                $('#id_jenisKPM').val(response.id);
                $('#tahun option[value="' + response.tahun_akademik_id + '"]').prop('selected', true);
                $('#jenis').val(response.nama);
                $('#deskripsi').val(response.deskripsi);
                $('#modalTmbJenisKPM').modal('show');
            });
        }
    </script>

    <script>
        function hapusJenisKPM(id) {
            let url = '{{ route('jenis_kpm.edit', ':id') }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                dataType: "JSON"
            }).done((response) => {
                Swal.fire({
                    title: 'Apa Anda Yakin?',
                    html: `Anda akan menghapus jenis KPM : <span class="font-weight-bold font-italic">${response.nama}</span>`,
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
                            url: "{{ route('jenis_kpm.delete') }}",
                            type: "DELETE",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": response.id
                            },
                            success: function(res) {
                                $('#tblJenisKPM').DataTable().ajax.reload(null,
                                    false);
                                Swal.fire(
                                    res.title,
                                    res.message,
                                    res.icon
                                );
                            },
                            error: function(res) {
                                $('#tblJenisKPM').DataTable().ajax.reload(null,
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
                            `Jenis KPM : ${response.nama} tidak jadi dihapus`,
                            'info'
                        )
                    }
                });
            });
        };
    </script>
@endsection
