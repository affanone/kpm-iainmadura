<div class="card-body table-responsive">
    <table id="dataTableGenerate" class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Posko</th>
                <th>Alamat Posko</th>
                <th>Tahun Akademik</th>
                <th>Total Mahasiswa</th>
                <th width="1px">Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $item)
                <tr>
                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}
                    </td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->tahun_akademik->semester . ' ' . $item->tahun_akademik->tahun . '/' . ($item->tahun_akademik->tahun + 1) }}
                    </td>
                    <td>{{ $item->total }} Mhs</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-secondary"
                                href="{{ route('dpl.kpm.detail', ['id' => $item->id]) }}">View</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    {{ $data->links('fakultas.paginate') }}
</div>
