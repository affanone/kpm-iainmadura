@extends('dpl.master_template')

@section('title', 'Mahasiswa')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Mahasiswa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Data Mahasiswa</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Mahasiswa</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblMahasiswa" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Prodi</th>
                                            <th>TTL</th>
                                            <th>Alamat</th>
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
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script>
        let tblMahasiswa = $("#tblMahasiswa").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dpl.mahasiswa.data') }}",
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
                    data: 'nim'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'prodi'
                },
                {
                    data: 'tmp_lahir'
                },
                {
                    data: 'alamat'
                }
            ],
            "paging": true,
            "columnDefs": [{
                "targets": "_all",
                "className": "dt-center cell-border"
            }],
            "responsive": true,
            "autoWidth": true,
            "dom": '<"mb-3"B><"clearfix"<"float-left"l><"float-right"f>>tr<"d-flex justify-content-between"ip>',
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
            }],
            'language': {
                "processing": "<div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>"
            }
        });
    </script>
@endsection
