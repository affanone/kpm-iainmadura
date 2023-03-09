<div class="card-body table-responsive">
    <table id="dataTableGenerate" class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
        <thead class="text-center">
            <tr>
                <th rowspan="2" width="1px">No</th>
                <th rowspan="2">Jenis KPM</th>
                <th rowspan="2">Tahun Akademik</th>
                <th colspan="3">Pendaftar</th>
                <th rowspan="2" width="1px">Opsi</th>
            </tr>
            <tr>
                <th>Belum Plotting</th>
                <th>Sudah Plotting</th>
                <th>Total Valid</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($info_pendaftar_kpm as $i => $item)
                <tr>
                    <td>{{ ($info_pendaftar_kpm->currentPage() - 1) * $info_pendaftar_kpm->perPage() + $loop->index + 1 }}
                    </td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->semester }}</td>
                    <td class="text-center">{{ $item->total_unplotting }}</td>
                    <td class="text-center">{{ $item->total_plotting }}</td>
                    <td class="text-center">{{ $item->total_plotting_valid }} /
                        {{ $item->total_unplotting + $item->total_plotting }}</td>
                    <td>
                        <a href="{{ route('laporan.kpm.detail', ['id' => $item->id]) }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">TOTAL</th>
                <th>{{ $info_total_pendaftar_kpm->total_unplotting }}</th>
                <th>{{ $info_total_pendaftar_kpm->total_plotting }}</th>
                <th>{{ $info_total_pendaftar_kpm->total_plotting_valid }} /
                    {{ $info_total_pendaftar_kpm->total_unplotting + $info_total_pendaftar_kpm->total_plotting }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    {{ $info_pendaftar_kpm->links('superadmin.laporan.paginate_info_pendaftar_kpm') }}
</div>
