<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Kpm;
use App\Models\Mahasiswa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function kpm_detail(Request $request)
    {
        $kpm = Kpm::select([
            'kpms.*',
            DB::raw("CONCAT(tahun_akademiks.semester,' ',tahun_akademiks.tahun,'/',tahun_akademiks.tahun+1) as semester"),
        ])
            ->join('tahun_akademiks', 'tahun_akademiks.id', '=', 'kpms.tahun_akademik_id')
            ->where('kpms.id', $request->id)
            ->first();

        $fakultas = \IainApi::get('api/fakultas?limit=1000');

        $mahasiswa = Mahasiswa::select([
            'mahasiswas.nim',
            'mahasiswas.nama',
            'mahasiswas.prodi',
            'mahasiswas.fakultas',
            DB::raw("subkpms.nama as kpm"),
            DB::raw("poskos.nama as posko"),
            DB::raw("pendaftarans.status as status"),
        ])
            ->join('pendaftarans', 'pendaftarans.mahasiswa_id', '=', 'mahasiswas.id')
            ->join('subkpms', 'subkpms.id', '=', 'pendaftarans.subkpm_id')
            ->join('kpms', 'kpms.id', '=', 'subkpms.kpm_id')
            ->when($request->fak, function ($db, $n) {
                $db->whereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(mahasiswas.fakultas, '|', 1), '|', -1) = '$n'");
            })
            ->where('kpms.id', $request->id)
            ->leftJoin('posko_pendaftarans', 'posko_pendaftarans.pendaftaran_id', '=', 'pendaftarans.id')
            ->leftJoin('poskos', 'poskos.id', '=', 'posko_pendaftarans.posko_id')
            ->orderByRaw('COALESCE(posko, "ZZZZZZZZZZ") ASC')
            ->orderBy(DB::raw("SUBSTRING_INDEX(mahasiswas.fakultas, '|', 1)"), 'ASC')
            ->orderBy(DB::raw("SUBSTRING_INDEX(mahasiswas.prodi, '|', 1)"), 'ASC')
            ->get();
        return view('superadmin.laporan.kpm_detail', [
            'kpm' => $kpm,
            'mahasiswa' => $mahasiswa,
            'fakultas' => $fakultas->data->data,
        ]);
    }

    public function kpm(Request $request)
    {

        $info_pendaftar_kpm = Kpm::select([
            'kpms.id',
            DB::raw("CONCAT(tahun_akademiks.semester,' ',tahun_akademiks.tahun,'/',tahun_akademiks.tahun+1) as semester"), 'kpms.nama', DB::raw('ifnull(p.total,0) as total_unplotting'),
            DB::raw('ifnull(p1.total,0) as total_plotting'),
            DB::raw('ifnull(p2.total,0) as total_plotting_valid'),
        ])
            ->join('subkpms', 'subkpms.kpm_id', '=', 'kpms.id')
            ->join('tahun_akademiks', 'tahun_akademiks.id', '=', 'kpms.tahun_akademik_id')
            ->leftJoin(DB::raw('(select p.subkpm_id, count(p.subkpm_id) total from pendaftarans p
                where not exists(
                    select * from posko_pendaftarans pp where pp.pendaftaran_id = p.id
                ) and p.status < 5 GROUP BY p.subkpm_id
            )p'), DB::raw('p.subkpm_id'), '=', DB::raw('subkpms.id'))
            ->leftJoin(DB::raw('(select p1.subkpm_id, count(p1.subkpm_id) total from pendaftarans p1
                where exists(
                    select * from posko_pendaftarans pp1 where pp1.pendaftaran_id = p1.id
                ) and p1.status < 5 GROUP BY p1.subkpm_id
            )p1'), DB::raw('p1.subkpm_id'), '=', DB::raw('subkpms.id'))
            ->leftJoin(DB::raw('(select p2.subkpm_id, count(p2.subkpm_id) total from pendaftarans p2
                where exists(
                    select * from posko_pendaftarans pp2 where pp2.pendaftaran_id = p2.id
                ) and p2.status > 3 GROUP BY p2.subkpm_id
            )p2'), DB::raw('p2.subkpm_id'), '=', DB::raw('subkpms.id'))
            ->when($request->tahun, function ($db, $n) {
                $db->where('tahun_akademiks.id', $n);
            })
            ->orderBy('kpms.tipe', 'asc')
            ->orderBy('tahun_akademiks.tahun', 'desc')
            ->orderBy('tahun_akademiks.semester', 'asc')
            ->paginate(10);

        $info_total_pendaftar_kpm = Kpm::select([
            DB::raw('sum(ifnull(p.total,0)) as total_unplotting'),
            DB::raw('sum(ifnull(p1.total,0)) as total_plotting'),
            DB::raw('sum(ifnull(p2.total,0)) as total_plotting_valid'),
        ])
            ->join('subkpms', 'subkpms.kpm_id', '=', 'kpms.id')
            ->join('tahun_akademiks', 'tahun_akademiks.id', '=', 'kpms.tahun_akademik_id')
            ->leftJoin(DB::raw('(select p.subkpm_id, count(p.subkpm_id) total from pendaftarans p
                where not exists(
                    select * from posko_pendaftarans pp where pp.pendaftaran_id = p.id
                ) and p.status < 5 GROUP BY p.subkpm_id
            )p'), DB::raw('p.subkpm_id'), '=', DB::raw('subkpms.id'))
            ->leftJoin(DB::raw('(select p1.subkpm_id, count(p1.subkpm_id) total from pendaftarans p1
                where exists(
                    select * from posko_pendaftarans pp1 where pp1.pendaftaran_id = p1.id
                ) and p1.status < 5 GROUP BY p1.subkpm_id
            )p1'), DB::raw('p1.subkpm_id'), '=', DB::raw('subkpms.id'))
            ->leftJoin(DB::raw('(select p2.subkpm_id, count(p2.subkpm_id) total from pendaftarans p2
                where exists(
                    select * from posko_pendaftarans pp2 where pp2.pendaftaran_id = p2.id
                ) and p2.status > 3 GROUP BY p2.subkpm_id
            )p2'), DB::raw('p2.subkpm_id'), '=', DB::raw('subkpms.id'))
            ->when($request->tahun, function ($db, $n) {
                $db->where('tahun_akademiks.id', $n);
            })
            ->orderBy('kpms.tipe', 'asc')
            ->orderBy('tahun_akademiks.tahun', 'desc')
            ->orderBy('tahun_akademiks.semester', 'asc')
            ->first();

        $datatable_info_kpm = view('superadmin.laporan.datatable_info_pendaftar_kpm', [
            'info_pendaftar_kpm' => $info_pendaftar_kpm,
            'info_total_pendaftar_kpm' => $info_total_pendaftar_kpm,
        ])->render();
        if ($request->ajax()) {
            return $datatable_info_kpm;
        }

        $tahun_akademik = TahunAkademik::whereExists(function ($db) {
            $db->select('*')
                ->from('kpms')
                ->whereRaw('kpms.tahun_akademik_id = tahun_akademiks.id');
        })
            ->orderBy('tahun_akademiks.tahun', 'desc')
            ->orderBy('tahun_akademiks.semester', 'asc')
            ->limit(7)
            ->get();

        return view('superadmin.laporan.kpm', [
            'tahun_akademik' => $tahun_akademik,
            'datatable_info_kpm' => $datatable_info_kpm,
        ]);
    }
}
