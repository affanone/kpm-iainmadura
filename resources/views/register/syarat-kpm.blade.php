@include('register.open')

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Upload Data Pendaftaran KPM</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('reg_upload_syarat') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            @if ($errors->daftar->first())
                                <div class="alert alert-danger">{{ $errors->daftar->first() }}</div>
                            @endif
                            <div class="form-group">
                                <label for="kpm">KPM Yang Dipilih</label>
                                <input type="text" class="form-control" id="kpm"
                                    value="{{ $pendaftaran->subkpm->kpm->nama }} | {{ $pendaftaran->subkpm->nama }}"
                                    disabled>
                            </div>


                            <div class="text-dark font-weight-bold">{{ $pendaftaran->subkpm->kpm->deskripsi }}</div>
                            <ul class="list-group mb-3">
                                @foreach ($pendaftaran->subkpm->kpm->config_upload as $key => $config)
                                    <li class="list-group-item">
                                        <div class="form-group">
                                            @if ($errors->has($config->name))
                                                <div class="alert alert-danger">{{ $errors->first($config->name) }}
                                                </div>
                                            @endif
                                            <label for="file_kpm_{{ $key }}">{{ $config->label }}
                                                @php
                                                    $formats = [];
                                                    foreach ($config->format as $fk => $fv) {
                                                        array_push($formats, $fk);
                                                    }
                                                    echo '(' . join(' / ', $formats) . ')';
                                                @endphp</label>
                                            <input type="file" name="{{ $config->name }}" class="form-control-file"
                                                id="file_kpm_{{ $key }}"
                                                aria-describedby="file_kpm_helper_{{ $key }}">
                                            <small id="file_kpm_helper_{{ $key }}"
                                                class="form-text text-muted">{{ $config->deskripsi }}
                                            </small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="text-dark font-weight-bold">{{ $pendaftaran->subkpm->deskripsi }}</div>
                            <ul class="list-group mb-3">
                                @foreach ($pendaftaran->subkpm->config_upload as $key => $config)
                                    <li class="list-group-item">
                                        <div class="form-group">
                                            @if ($errors->has($config->name))
                                                <div class="alert alert-danger">{{ $errors->first($config->name) }}
                                                </div>
                                            @endif
                                            <label for="file_kpm_in_{{ $key }}">{{ $config->label }}
                                                @php
                                                    $formats = [];
                                                    foreach ($config->format as $fk => $fv) {
                                                        array_push($formats, $fk);
                                                    }
                                                    echo '(' . join(' / ', $formats) . ')';
                                                @endphp</label>
                                            <input type="file" name="{{ $config->name }}" class="form-control-file"
                                                id="file_kpm_in_{{ $key }}"
                                                aria-describedby="file_kpm_helper_in_{{ $key }}">
                                            <small id="file_kpm_helper_in_{{ $key }}"
                                                class="form-text text-muted">{{ $config->deskripsi }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
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