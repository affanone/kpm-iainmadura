@extends('fakultas.master_template')

@section('title', 'Penempatan Peserta')

@section('style')
    <style>
        /* Auto Number Table */
        .autonumber {
            counter-reset: row-number;
        }

        .autonumber td:first-child:before {
            counter-increment: row-number;
            content: counter(row-number);
        }
    </style>
@endsection

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
            <div class="container-fluid" id="app-vue">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    POSKO :
                                </h3>
                                <div class="card-tools" style="float: left; margin-left: .5rem;">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <select class="custom-select" id="posko" v-model="filter.posko"
                                            v-on:change="filterPosko()">
                                            <option v-for="(item, key) in data_posko" :value="item.id">
                                                @{{ item.nama }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title">Total Pendaftar:
                                                                <span>@{{ countPendaftar }}</span>
                                                            </h5>
                                                            <div class="card-tools">
                                                                <div class="input-group input-group-sm"
                                                                    style="width: 250px;">
                                                                    <select class="custom-select" id="prodi"
                                                                        v-model="filter.prodi" v-on:change="getFilter()">
                                                                        <option selected value="">All</option>
                                                                        @foreach ($prodi as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->long }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <input type="text" name="search"
                                                                        v-model="filter.cari"
                                                                        class="form-control float-right" id="filterCari"
                                                                        placeholder="Search" style="width: 100px;"
                                                                        v-on:keyup.enter="getFilter()">

                                                                    <div class="input-group-append">
                                                                        <button type="button" class="btn btn-default"
                                                                            v-on:click="getFilter()">
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0" style="height: 750px;">
                                                            <table id="tableKiri"
                                                                class="table table-sm table-bordered table-hover table-head-fixed text-nowrap autonumber">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">No</th>
                                                                        <th>Nama Mahasiswa</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <template v-for="(item, key) in mahasiswa">
                                                                        <tr :class="item.cek != 0 ? 'd-none' : ''">
                                                                            <td></td>
                                                                            <td>
                                                                                <a role="button"
                                                                                    v-on:click="pindahKeKanan(item)"
                                                                                    class="font-weight-bold">@{{ item.mahasiswa.nama }}</a>
                                                                                <ul class="nav flex-column">
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.mahasiswa.nim }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.mahasiswa.prodi.long + ' (' + item.mahasiswa.prodi.fakultas.nama + ')' }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.mahasiswa.alamat }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.subkpm.nama }}</span>
                                                                                    </li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title">Peserta Sudah Masuk Posko :
                                                                <span>@{{ posko_pendaftaran.length }}</span>
                                                            </h5>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0" style="height: 750px;">
                                                            <table id="tableKanan"
                                                                class="table table-sm table-bordered table-hover table-head-fixed text-nowrap autonumber">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">No</th>
                                                                        <th>Nama Mahasiswa</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <template v-for="(item, key) in posko_pendaftaran">
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>
                                                                                <a role="button"
                                                                                    v-on:click="pindahKeKiri(item,key)"
                                                                                    class="font-weight-bold">@{{ item.mahasiswa.nama }}</a>
                                                                                <ul class="nav flex-column">
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.mahasiswa.nim }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.mahasiswa.prodi.long + ' (' + item.mahasiswa.prodi.fakultas.nama + ')' }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.mahasiswa.alamat }}</span>
                                                                                    </li>
                                                                                    <li class="nav-item p-1">
                                                                                        <span
                                                                                            class="badge bg-olive">@{{ item.subkpm.nama }}</span>
                                                                                    </li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    </template>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app-vue',
            data: {
                filter: {
                    cari: '',
                    prodi: '',
                    posko: '{{ $posko->id }}'
                },
                posko_pendaftaran: [],
                mahasiswa: @json($mahasiswa),
                data_posko: @json($data_posko)
            },
            computed: {
                countPendaftar() {
                    let total_pendaftar = 0;
                    this.mahasiswa.map((item) => {
                        total_pendaftar += +item.cek == '0';
                    });
                    return total_pendaftar;
                }
            },
            methods: {
                pindahKeKanan(item) {
                    // Proses Simpan
                    $.ajax({
                        type: "POST",
                        url: "{{ route('fakultas.posko.penempatan.post') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id_peserta": item.id,
                            "id_posko": "{{ $posko->id }}"
                        },
                        dataType: 'JSON',
                        success: function(res) {
                            const msg = JSON.parse(JSON.stringify(res));
                        },
                        error: function(res) {
                            // console.log(JSON.parse(JSON.stringify(res)));
                            Swal.fire(
                                'Gagal',
                                'Ada Kesalahan',
                                'error'
                            );
                        }
                    });

                    item.cek = item.id;
                    app.posko_pendaftaran.push(item);
                },
                pindahKeKiri(item, key) {
                    $.ajax({
                        url: "{{ route('fakultas.posko.penempatan.delete') }}",
                        type: "DELETE",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id_peserta": item.id,
                            "id_posko": "{{ $posko->id }}"
                        },
                        success: function(res) {
                            const msg = JSON.parse(JSON.stringify(res));
                        },
                        error: function(res) {
                            Swal.fire(
                                'Gagal',
                                'Ada Kesalahan',
                                'error'
                            );
                        }
                    });

                    let i = app.posko_pendaftaran.map(e => e.id).indexOf(item.id);
                    app.posko_pendaftaran[i].cek = 0;
                    app.posko_pendaftaran.splice(key, 1);
                },
                getFilter() {
                    let url = "{{ route('fakultas.posko.penempatan', ':id') }}";
                    url = url.replace(':id', "{{ $posko->id }}");
                    $.ajax({
                        url: url,
                        data: {
                            prodi: app.filter.prodi,
                            cari: app.filter.cari
                        },
                        success: function(data) {
                            app.mahasiswa = data;
                        }
                    });
                },
                filterPosko() {
                    let url = "{{ route('fakultas.posko.penempatan', ':id') }}";
                    url = url.replace(':id', app.filter.posko);
                    window.location = url;
                },
                pindahKananOtomatis() {
                    app.mahasiswa.forEach(element => {
                        if (element.cek != 0) {
                            app.pindahKeKanan(element);
                        }
                    });
                }
            },
        });
        app.pindahKananOtomatis();
    </script>
@endsection
