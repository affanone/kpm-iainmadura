@include('register.open')

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Finalisasi Pendaftaran KPM</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('mhs.reg.final') }}">
                        @csrf
                        <div class="card-body">
                            @if ($errors->final->first())
                                <div class="alert alert-danger">{{ $errors->final->first() }}</div>
                            @else
                                @if (session('status') == 0)
                                    <div class="alert alert-info">Berikut data yang telah anda isi, periksa kembali dan
                                        apabila
                                        sudah benar maka silahkan anda centang pada setiap datanya, apabila terdapat
                                        kesalahan
                                        silahkan perbaiki data yang salah
                                    </div>
                                @elseif(session('status') == 1)
                                    <div class="alert alert-warning">
                                        Proses Pendaftaran anda berhasil dikirim dan sedang menunggu untuk
                                        <strong>divalidasi</strong>
                                    </div>
                                @elseif(session('status') == 3)
                                    <div class="alert alert-success">
                                        Proses Pendaftaran telah divalidasi, silahkan menunggu informasi untuk proses
                                        selanjutnya
                                    </div>
                                @endif
                            @endif
                            <ul class="list-group mb-4">
                                <div class="h3">Data Diri Mahasiswa</div>
                                <li class="list-group-item">
                                    <small class="text-muted">NIM</small>
                                    <div class="font-weight-bold">{{ $mhs->nim }} <span
                                            class="text-primary font-weight-bold">Otomatis</span>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-muted">Nama</small>
                                    <div class="font-weight-bold">{{ $mhs->nama }} <span
                                            class="text-primary font-weight-bold">Otomatis</span>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-muted">Fakultas / Prodi</small>
                                    <div class="font-weight-bold">{{ $mhs->prodi->fakultas->nama }} /
                                        {{ $mhs->prodi->long }} <span
                                            class="text-primary font-weight-bold">Otomatis</span>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-muted">Jenis Kelamin</small>
                                    <div class="font-weight-bold">{{ $mhs->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        <span class="text-primary font-weight-bold">Otomatis</span>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-muted">Nomor HP / WhatsApp</small>
                                    <div class="font-weight-bold">{{ $mhs->hp }}
                                        @if (in_array(session('status') ?? 0, [0, 2]))
                                            <input type="checkbox" class="checked-valid"
                                                @if (old('hp')) checked @endif name="hp">
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-muted">Alamat Tempat Tinggal Saat Ini</small>
                                    <div class="font-weight-bold">{{ $mhs->alamat }}
                                        @if (in_array(session('status') ?? 0, [0, 2]))
                                            <input type="checkbox" class="checked-valid"
                                                @if (old('alamat')) checked @endif name="alamat">
                                    </div>
                                    @endif
                                </li>
                            </ul>


                            <ul class="list-group mb-4">
                                <div class="h3">Berkas Persyaratan Pendaftaran KPM</div>
                                <li class="list-group-item">
                                    <small class="text-muted">KPM Yang Dipilih</small>
                                    <div class="font-weight-bold">
                                        {{ $pendaftaran->subkpm->kpm->nama }} > {{ $pendaftaran->subkpm->nama }}
                                    </div>
                                </li>
                                @foreach ($pendaftaran->subkpm->kpm->config->upload as $key => $config)
                                    <li class="list-group-item">
                                        <small class="text-muted">{{ $config->label }}</small>
                                        @php
                                            $a = collect($document)->first(function ($i) use ($config) {
                                                return $i ? $i->desc->name == $config->name : false;
                                            });
                                        @endphp
                                        <div>
                                            @if ($a)
                                                <a href="{{ $a->url }}?filename={{ $a->name }}"
                                                    target="_blank"
                                                    class="btn-link font-weight-bold">{{ $a->name }}</a>
                                                @if (in_array(session('status') ?? 0, [0, 2]))
                                                    <input type="checkbox" class="checked-valid"
                                                        @if (old($config->name)) checked @endif
                                                        name="{{ $config->name }}">
                                                @endif
                                            @else
                                                <span class="text-danger">Berkas tidak di upload</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                                @foreach ($pendaftaran->subkpm->config->upload as $key => $config)
                                    <li class="list-group-item">
                                        <small class="text-muted">{{ $config->label }}</small>
                                        @php
                                            $a = collect($document)->first(function ($i) use ($config) {
                                                return $i ? $i->desc->name == $config->name : false;
                                            });
                                        @endphp
                                        <div>
                                            @if ($a)
                                                <a href="{{ $a->url }}?filename={{ $a->name }}"
                                                    target="_blank"
                                                    class="btn-link font-weight-bold">{{ $a->name }}</a>
                                                @if (in_array(session('status') ?? 0, [0, 2]))
                                                    <input type="checkbox" class="checked-valid"
                                                        @if (old($config->name)) checked @endif
                                                        name="{{ $config->name }}">
                                                @endif
                                            @else
                                                <span class="text-danger">Berkas tidak di upload</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.card-body -->

                        @if (in_array(session('status') ?? 0, [0, 2]))
                            <div class="card-footer">
                                <div class="alert alert-danger">Setelah anda men-<strong>SUBMIT PENDAFTARAN</strong>
                                    maka
                                    anda
                                    tidak dapat mengedit data yang sudah dikirim, <strong>PERIKSALAH KEMBALI</strong>
                                    lalu
                                    klik tombol dibawah
                                    ini apabila ingin
                                    mengakhiri form pendaftaran KPM</div>
                                <button onclick="return confirm('Yakin anda akan mensubmit proses pendaftaran?');"
                                    type="submit" class="btn btn-primary">SUBMIT PENDAFTARAN</button>
                            </div>
                        @endif
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
