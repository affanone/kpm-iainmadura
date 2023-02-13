@include('register.open')

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Jenis KPM</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('reg_update_kpm') }}">
                        @csrf
                        <div class="card-body">
                            @if ($errors->has('jeniskpm'))
                                <div class="alert alert-danger">{{ $errors->first('jeniskpm') }}</div>
                            @endif
                            @foreach ($kpm as $key => $item)
                                <div class="form-group mb-5">
                                    <label>{{ $item->nama }}</label>
                                    <div class="text-primary">{{ $item->deskripsi }}</div>
                                    @foreach ($item->subkpm as $key1 => $sub)
                                        <div class="form-check">
                                            <div class="font-style text-muted small">{{ $sub->deskripsi }}</div>
                                            <input type="radio" class="form-check-input" value="{{ $sub->id }}"
                                                id="kpm_{{ $key . $key1 }}" name="jeniskpm"
                                                @if ($jeniskpm == $sub->id) checked @endif>
                                            <label class="form-check-label"
                                                for="kpm_{{ $key . $key1 }}">{{ $sub->nama }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
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
