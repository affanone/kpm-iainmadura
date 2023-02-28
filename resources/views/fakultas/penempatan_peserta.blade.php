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
                                        <div class="col-12">
                                            <div class="form-group">
                                                <select class="duallistbox" multiple="multiple" name="mahasiswa[]"
                                                    id="mahasiswa">
                                                    @foreach ($mahasiswa as $item)
                                                        <option value="{{ $item->id }}">
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
