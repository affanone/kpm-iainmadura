@extends('fakultas.master_template')

@section('title', 'Penempatan Peserta')

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
                            <form id="formPenempatan">
                                @csrf
                                <input type="hidden" value="{{ $posko->id }}" name="id_posko">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="table-responsive">
                                                <table id="tableKiri"
                                                    class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th>Nama Posko</th>
                                                            <th>Alamat Posko</th>
                                                            <th>Tahun Akademik</th>
                                                            <th>DPL</th>
                                                            <th width="7%">Opsi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="table-responsive">
                                                <table id="tableKanan"
                                                    class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th>Nama Mahasiswa</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($mahasiswa as $item)
                                                            <tr>
                                                                <td>{{ $no }}</td>
                                                                <td>
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item active">
                                                                            {{ $item->mahasiswa->nama }}
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            {{ $item->mahasiswa->prodi->long . ' (' . $item->mahasiswa->prodi->fakultas->nama . ')' }}
                                                                        </li>
                                                                        <li class="list-group-item">
                                                                            {{ $item->subkpm->nama }}</li>
                                                                        <li class="list-group-item">Porta ac consectetur ac
                                                                        </li>
                                                                        <li class="list-group-item">Vestibulum at eros</li>
                                                                    </ul>
                                                            </tr>
                                                            @php
                                                                $no++;
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>



                                        <div class="col-12">
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
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary float-right"
                                        id="btnSmpPenempatan">Simpan</button>
                                </div>
                            </form>
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
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox({
            // 'string_of_postfix' / false                                                      
            helperSelectNamePostfix: false,

            // minimal height in pixels
            selectorMinimalHeight: 300,
        });

        $('#btnSmpPenempatan').on('click', () => {
            $.ajax({
                type: "POST",
                url: "{{ route('fakultas.posko.penempatan.post') }}",
                data: $('#formPenempatan').serialize(),
                dataType: 'JSON',
                success: function(res) {
                    const msg = JSON.parse(JSON.stringify(res));
                    Swal.fire({
                        icon: msg.icon,
                        title: "Berhasil",
                        text: msg.message
                    });
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
        });
    </script>
@endsection
