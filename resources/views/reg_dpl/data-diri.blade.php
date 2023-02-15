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
                    <form method="post" action="#">
                        @csrf
                        <div class="card-body">
                            @if ($errors->daftar->first())
                                <div class="alert alert-danger">{{ $errors->daftar->first() }}</div>
                            @endif
                            <div class="form-group">
                                <label for="nip_nidn">NIP/NIDN</label>
                                <input type="text" class="form-control" id="nip_nidn" value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Dosen</label>
                                <input type="text" class="form-control" id="nama" value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tmp_lhr">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tmp_lhr" value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lhr">Tanggal Lahir</label>
                                <input type="text" class="form-control" id="tgl_lhr" value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" value="L" id="jeniskelaminl"
                                        disabled>
                                    <label class="form-check-label" for="jeniskelaminl">Laki-laki</label>
                                </div>

                                <div class="form-check">
                                    <input type="radio" class="form-check-input" value="P" id="jeniskelaminp"
                                        disabled>
                                    <label class="form-check-label" for="jeniskelaminp">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('hp')) alert alert-danger  error @endif">
                                @if ($errors->has('hp'))
                                    <div class="font-italic">{{ $errors->first('hp') }}</div>
                                @endif
                                <label for="hp">Nomor HP / WhatsApp<strong class="text-danger">*</strong></label>
                                <input type="number" class="form-control" id="hp" name="hp" value=""
                                    @if (!in_array(session('status') ?? 0, [0, 2])) disabled @endif>
                            </div>
                            <div class="form-group @if ($errors->has('alamat')) alert alert-danger  error @endif">
                                @if ($errors->has('alamat'))
                                    <div class="font-italic">{{ $errors->first('alamat') }}</div>
                                @endif
                                <label for="alamat">Alamat Tempat Tinggal Saat Ini<strong
                                        class="text-danger">*</strong></label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat"
                                    @if (!in_array(session('status') ?? 0, [0, 2])) disabled @endif></textarea>
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
