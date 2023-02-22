<div class="card-body table-responsive">
    <table id="dataTableGenerate" class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Posko</th>
                <th>Alamat Posko</th>
                <th>Tahun Akademik</th>
                <th>DPL</th>
                <th width="7%">Opsi</th>
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
                    <td>{{ $item->dpl->nama }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a type="button" class="btn btn-secondary" href="#">Edit</a>
                            <a type="button" class="btn btn-secondary" href="#">Delete</a>
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
