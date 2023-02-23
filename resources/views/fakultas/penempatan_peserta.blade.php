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
                                <h3 class="card-title">Bootstrap Duallistbox</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="" id="">
                                                        <option value="">-- Pilih Program Studi --</option>
                                                        @foreach ($prodi as $item)
                                                            <option value="{{ $item->id }}">{{ $item->long }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="" id="">
                                                        <option value="">-- Pilih Posko --</option>
                                                        @foreach ($posko as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->nama . ' (' . $item->alamat . ')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <select class="duallistbox" multiple="multiple" name="mahasiswa" id="mahasiswa">
                                                @foreach ($mahasiswa as $item)
                                                    <option value="{{ $item->user_id }}">
                                                        {{ $item->nama . ' - ' . $item->prodi->long . ' (' . $item->pendaftaran->subkpm->nama . ')' }}
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
                                Visit <a href="https://github.com/istvan-ujjmeszaros/bootstrap-duallistbox#readme">Bootstrap
                                    Duallistbox</a> for more examples and information about
                                the plugin.
                            </div>
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
    </script>
@endsection
