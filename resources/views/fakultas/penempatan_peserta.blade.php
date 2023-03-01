@extends('fakultas.master_template')

@section('title', 'Penempatan Peserta')

@section('style')
    <style>
        table.autonumber {
            border-collapse: collapse;
            width: 100%;
        }

        .autonumber th,
        .autonumber td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .autonumber th {
            background-color: #f2f2f2;
        }

        .autonumber tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Ganti angka dengan nomor urut */
        .autonumber.table-number {
            counter-reset: row-number;
        }

        .autonumber.table-number td:first-child:before {
            counter-increment: row-number;
            content: counter(row-number);
            min-width: 1em;
            margin-right: 0.5em;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Penempatan Peserta KPM</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('fakultas.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fakultas.posko') }}">Posko</a></li>
                            <li class="breadcrumb-item active">Penempatan Peserta</li>
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
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">POSKO : {{ $posko->nama . ' (' . $posko->alamat . ')' }}
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            {{-- <form id="formPenempatan">
                                @csrf
                                <input type="hidden" value="{{ $posko->id }}" name="id_posko"> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title">Total Pendaftar : <span
                                                                    id="pesertaKiri">0</span>
                                                            </h5>
                                                            <div class="card-tools">
                                                                <div class="input-group input-group-sm"
                                                                    style="width: 250px;">
                                                                    <select class="custom-select" id="prodi"
                                                                        onchange="getFilterProdi(this.value)">
                                                                        <option selected value="">All</option>
                                                                        @foreach ($prodi as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->long }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <input type="text" name="search"
                                                                        class="form-control float-right" id="filterCari"
                                                                        placeholder="Search" style="width: 100px;"
                                                                        onkeyup="if (event.keyCode === 13) getFilterCari()">

                                                                    <div class="input-group-append">
                                                                        <button type="button" class="btn btn-default"
                                                                            onclick="getFilterCari()">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0" style="height: 750px;">
                                                            <table id="tableKiri"
                                                                class="table table-sm table-bordered table-striped table-hover table-head-fixed text-nowrap table-number autonumber">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">No</th>
                                                                        <th>Nama Mahasiswa</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($mahasiswa as $key => $item)
                                                                        <tr
                                                                            @if ($item->cek !== '0') class="selectedPeserta urut-{{ $key }}" data-key="{{ $key }}" @endif>
                                                                            <td></td>
                                                                            <td>
                                                                                <a href="#"
                                                                                    data-id="{{ $item->id }}"
                                                                                    class="font-weight-bold selectPeserta">{{ $item->mahasiswa->nama }}</a>
                                                                                <ul class="nav flex-column">
                                                                                    <li class="nav-item p-1">
                                                                                        NIM <span
                                                                                            class="badge bg-olive">{{ $item->mahasiswa->nim }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        Program Studi <span
                                                                                            class="badge bg-olive">{{ $item->mahasiswa->prodi->long . ' (' . $item->mahasiswa->prodi->fakultas->nama . ')' }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        Alamat <span
                                                                                            class="badge bg-olive">{{ $item->mahasiswa->alamat }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        KPM <span
                                                                                            class="badge bg-olive">{{ $item->subkpm->nama }}</span>
                                                                                    </li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title">Peserta Sudah Masuk Posko : <span
                                                                    id="pesertaKanan">0</span></h5>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0" style="height: 750px;">
                                                            <table id="tableKanan"
                                                                class="table table-sm table-bordered table-striped table-hover table-head-fixed text-nowrap table-number autonumber">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">No</th>
                                                                        <th>Nama Mahasiswa</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-12">
                                        <div class="form-group">
                                            <select class="duallistbox" multiple="multiple" name="mahasiswa[]"
                                                id="mahasiswa">
                                                @foreach ($mahasiswa as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if ($item->cek !== '0') selected @endif>
                                                        {{ $item->mahasiswa->nama . ' - ' . $item->mahasiswa->prodi->long . ' (' . $item->subkpm->nama . ')' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div> --}}
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer">
                                <button type="button" class="btn btn-primary float-right"
                                    id="btnSmpPenempatan">Simpan</button>
                            </div>
                            </form> --}}
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        let ajaxNilai = false;

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox({
            // 'string_of_postfix' / false                                                      
            helperSelectNamePostfix: false,

            // minimal height in pixels
            selectorMinimalHeight: 300,
        });

        // Fetch Data dan Filter
        let filter = {
            p: '',
            q: ''
        }

        function fetchData() {
            let url = "{{ route('fakultas.posko.penempatan', ':id') }}";
            url = url.replace(':id', "{{ $posko->id }}");
            $.ajax({
                url: url,
                data: {
                    prodi: filter.p,
                    cari: filter.q
                },
                success: function(data) {
                    $('#tableKiri tbody tr').remove();

                    let no = 1;
                    data.forEach((item) => {
                        let elem = `
                        <tr>
                            <td></td>
                            <td>
                                <a href="#" data-id="${item.id}" class="font-weight-bold selectPeserta">
                                    ${item.mahasiswa.nama}
                                </a>
                                <ul class="nav flex-column">
                                    <li class="nav-item p-1">
                                        NIM
                                        <span class="badge bg-olive">${item.mahasiswa.nim}</span>
                                    </li>
                                    <li class="nav-item p-1">
                                        Program Studi 
                                        <span class="badge bg-olive">${item.mahasiswa.prodi.long} (${item.mahasiswa.prodi.fakultas.nama})</span>
                                    </li>
                                    <li class="nav-item p-1">
                                        Alamat
                                        <span class="badge bg-olive">${item.mahasiswa.alamat}</span>
                                    </li>
                                    <li class="nav-item p-1">
                                        KPM
                                        <span class="badge bg-olive">${item.subkpm.nama}</span>
                                    </li> 
                                </ul>
                            </td>
                        </tr>`;
                        $('#tableKiri > tbody:last-child').append(elem);
                        no++;
                    });
                    selectPeserta();
                }
            });
        }

        function getFilterCari() {
            filter.q = $('#filterCari').val();
            fetchData();
        }

        function getFilterProdi(value) {
            filter.p = value;
            fetchData();
        }

        // Select dan Remove Peserta
        function selectPeserta() {
            $('.selectPeserta').on('click', function() {
                const tr_kiri = $(this).closest('tr');
                const id = tr_kiri.find('a').data('id');
                tr_kiri.css({
                    'display': 'none'
                });

                // Proses Simpan
                if (ajaxNilai) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('fakultas.posko.penempatan.post') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id_peserta": id,
                            "id_posko": "{{ $posko->id }}"
                        },
                        dataType: 'JSON',
                        success: function(res) {
                            const msg = JSON.parse(JSON.stringify(res));
                            // Swal.fire({
                            //     icon: msg.icon,
                            //     title: "Berhasil",
                            //     text: msg.message
                            // });
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
                }

                $('#tableKanan tbody')
                    .append('<tr>' + tr_kiri.html() + '</tr>')
                    .find('a')
                    .attr('class', 'text-bold removePeserta');

                $('.removePeserta').on('click', function() {
                    const tr_kanan = $(this).closest('tr');
                    const id = tr_kanan.find('a').data('id');
                    tr_kanan.remove();
                    $('[data-id="' + id + '"]').closest('tr').attr({
                        'style': ''
                    });
                });

                $('#pesertaKiri').html($('#tableKiri > tbody > tr:not([style*="display: none"])').length);
                $('#pesertaKanan').html($('#tableKanan > tbody > tr').length);
            });
        }
        selectPeserta();

        // // Proses Simpan
        // $('#btnSmpPenempatan').on('click', () => {
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('fakultas.posko.penempatan.post') }}",
        //         data: $('#formPenempatan').serialize(),
        //         dataType: 'JSON',
        //         success: function(res) {
        //             const msg = JSON.parse(JSON.stringify(res));
        //             Swal.fire({
        //                 icon: msg.icon,
        //                 title: "Berhasil",
        //                 text: msg.message
        //             });
        //         },
        //         error: function(res) {
        //             $('#tblAdmFakultas').DataTable().ajax.reload(null,
        //                 false);
        //             Swal.fire(
        //                 'Gagal',
        //                 'Ada Kesalahan',
        //                 'error'
        //             );
        //         }
        //     });
        // });

        const a = $('tr.selectedPeserta');
        for (let i = 0; i < a.length; i++) {
            let key = $(a[i]).attr('data-key');
            $(`tr.urut-${key} .selectPeserta`).trigger('click');
        }
        ajaxNilai = true;
    </script>
@endsection
