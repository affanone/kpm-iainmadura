<div class="card-body table-responsive">
    <table id="dataTableGenerate" class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Posko</th>
                <th>Alamat Posko</th>
                <th>Tahun Akademik</th>
                <th>Total Mahasiswa</th>
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
                    <td>{{ $item->total }} Mhs</td>
                    <td>
                        <form action="{{ route('fakultas.posko') }}" method="POST" class="btn-group" role="group"
                            aria-label="Basic example">
                            <a class="btn btn-secondary"
                                href="{{ route('fakultas.posko.edit', ['id' => $item->id]) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary"
                                href="{{ route('fakultas.posko.delete', ['id' => $item->id]) }}"
                                onclick="return confirm('Hapus data posko?')">Delete</button>
                        </form>
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
