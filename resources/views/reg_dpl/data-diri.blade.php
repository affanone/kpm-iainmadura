@include('reg_dpl.open')

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
                    <form method="post" action="{{ route('dpl.reg.profil.post') }}">
                        @csrf
                        <div class="card-body">
                            @if ($errors->daftar->first())
                                <div class="alert alert-danger">{{ $errors->daftar->first() }}</div>
                            @endif
                            <div class="form-group">
                                <label for="nip_nidn">NIP/NIDN</label>
                                <input type="text" class="form-control" id="nip_nidn" value="{{ $nip ?? $nidn }}"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Dosen</label>
                                <input type="text" class="form-control" id="nama" value="{{ $nama }}"
                                    disabled>
                            </div>
                            <div class="form-group @if ($errors->has('hp')) alert alert-danger  error @endif">
                                @if ($errors->has('hp'))
                                    <div class="font-italic">{{ $errors->first('hp') }}</div>
                                @endif
                                <label for="hp">Nomor HP / WhatsApp<strong class="text-danger">*</strong></label>
                                <input type="number" class="form-control" id="hp" name="hp" value="">
                            </div>
                            <div class="form-group @if ($errors->has('alamat')) alert alert-danger  error @endif">
                                @if ($errors->has('alamat'))
                                    <div class="font-italic">{{ $errors->first('alamat') }}</div>
                                @endif
                                <label for="alamat">Alamat Tempat Tinggal Saat Ini<strong
                                        class="text-danger">*</strong></label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat">{{ $alamat }}</textarea>
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
@include('reg_dpl.close')
