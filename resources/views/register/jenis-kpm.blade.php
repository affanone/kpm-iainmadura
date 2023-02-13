@include('register.open')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="m-0">Form Pendaftaran <small>{{ $nama_kpm }}</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Diri</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('register') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <input type="text" class="form-control" id="nim" value="{{ $data->nim }}"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama" value="{{ $data->nama }}"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" value="L" id="jeniskelaminl"
                                        {{ $data->kelamin == 'L' ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="jeniskelaminl">Laki-laki</label>
                                </div>

                                <div class="form-check">
                                    <input type="radio" class="form-check-input"
                                        {{ $data->kelamin == 'P' ? 'checked' : '' }} value="P" id="jeniskelaminp"
                                        disabled>
                                    <label class="form-check-label" for="jeniskelaminp">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('hp')) alert alert-danger  error @endif">
                                @if ($errors->has('hp'))
                                    <div class="font-italic">{{ $errors->first('hp') }}</div>
                                @endif
                                <label for="hp">Nomor HP / WhatsApp<strong class="text-danger">*</strong></label>
                                <input type="number" class="form-control" id="hp" name="hp"
                                    value="{{ old('hp') }}">
                            </div>
                            <div class="form-group @if ($errors->has('alamat')) alert alert-danger  error @endif">
                                @if ($errors->has('alamat'))
                                    <div class="font-italic">{{ $errors->first('alamat') }}</div>
                                @endif
                                <label for="alamat">Alamat Tinggal Saat Ini<strong
                                        class="text-danger">*</strong></label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}"></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@include('register.close')
