@include('register.open')

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
                    <form method="post" action="{{ $step > 0 ? route('reg_update_profil') : route('register') }}">
                        @csrf
                        <div class="card-body">
                            @if ($errors->daftar->first())
                                <div class="alert alert-danger">{{ $errors->daftar->first() }}</div>
                            @endif
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <input type="text" class="form-control" id="nim" value="{{ $mhs->nim }}"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama" value="{{ $mhs->nama }}"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="nama">Fakultas / Prodi</label>
                                <input type="text" class="form-control" id="nama"
                                    value="{{ $mhs->prodi->fakultas->nama . ' / ' . $mhs->prodi->long }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" value="L" id="jeniskelaminl"
                                        {{ $mhs->kelamin == 'L' ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="jeniskelaminl">Laki-laki</label>
                                </div>

                                <div class="form-check">
                                    <input type="radio" class="form-check-input"
                                        {{ $mhs->kelamin == 'P' ? 'checked' : '' }} value="P" id="jeniskelaminp"
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
                                    value="{{ old('hp', $hp) }}">
                            </div>
                            <div class="form-group @if ($errors->has('alamat')) alert alert-danger  error @endif">
                                @if ($errors->has('alamat'))
                                    <div class="font-italic">{{ $errors->first('alamat') }}</div>
                                @endif
                                <label for="alamat">Alamat Tinggal Saat Ini<strong
                                        class="text-danger">*</strong></label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat">{{ old('alamat', $alamat) }}</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan & Lanjut</button>
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
