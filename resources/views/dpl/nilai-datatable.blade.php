<div class="pl-4 pt-4">
    <strong><i>*Keterangan Nilai</i></strong><br>
    @foreach ($aspek as $key => $item)
        <div><strong>N{{ $key + 1 }}</strong> = {{ $item->aspek }}</div>
    @endforeach
</div>
<div class="card-body table-responsive">
    <form method="post" action="{{ route('dpl.nilai.post') }}">
        <table id="dataTableGenerate" class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th width="1px" rowspan="2">No</th>
                    <th rowspan="2">NIM</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Prodi</th>
                    <th rowspan="2">Posko</th>
                    <th colspan="{{ count($aspek) + 1 }}">Nilai</th>
                </tr>
                <tr>
                    @foreach ($aspek as $key => $item)
                        <th class="form-nilai-kpm"><strong>N{{ $key + 1 }}</strong> (0-100)</th>
                    @endforeach
                    <th class="form-nilai-kpm">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $item)
                    @php
                        $nilai = [];
                        foreach ($item->nilai as $nk => $vk) {
                            $nilai[$vk->aspek] = $vk->nilai;
                        }
                    @endphp
                    @csrf
                    <tr>
                        <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}
                        </td>
                        <td>{{ $item->mahasiswa->nim }}</td>
                        <td>{{ $item->mahasiswa->nama }}</td>
                        <td>{{ $item->mahasiswa->prodi->sort }}</td>
                        <td>{{ $item->posko }}</td>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($aspek as $key => $asp)
                            @php
                                $total += (($nilai[$asp->aspek] ?? 0) / 100) * $asp->persen;
                            @endphp
                            <td>
                                <input type="number" name="n{{ $key + 1 }}__{{ $item->id }}"
                                    class="form-control text-center" value="{{ $nilai[$asp->aspek] ?? '' }}">
                            </td>
                        @endforeach
                        <td>
                            {{ round($total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="{{ count($aspek) + 5 }}" class="text-right">
                        <button class="btn btn-success" type="submit">SIMPAN</button>
                    </th>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    {{ $data->links('dpl.paginate') }}
</div>
