<?php

namespace App\Http\Controllers\Dpl;

use App\Http\Controllers\Controller;
use App\Models\AspekPenilaian;
use App\Models\Nilai;
use App\Models\Pendaftaran;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $peserta = Pendaftaran::select('pendaftarans.*', DB::raw('poskos.nama as posko'))
            ->whereHas('subkpm.kpm.tahun_akademik', function ($db) {
                $db->where('status', 1);

            })->whereExists(function ($db) use ($request) {
            $db->select('*')
                ->from('posko_pendaftarans')
                ->whereRaw('posko_pendaftarans.pendaftaran_id = pendaftarans.id')
                ->whereExists(function ($db) use ($request) {
                    $db->select('*')
                        ->from('poskos')
                        ->whereRaw('poskos.id = posko_pendaftarans.posko_id')
                        ->when($request->posko, function ($db, $n) {
                            $db->where('poskos.id', $n);
                        })
                        ->whereExists(function ($db) {
                            $db->select('*')
                                ->from('dpls')
                                ->whereRaw('dpls.id = poskos.dpl_id')
                                ->where('dpls.user_id', session('user')->id);
                        });
                });
        })
            ->join('mahasiswas', function ($db) use ($request) {
                $db->on('mahasiswas.id', '=', 'pendaftarans.mahasiswa_id')
                    ->when($request->cari, function ($db, $n) {
                        $db->where('nama', 'like', '%' . $n . '%');
                    });
            })
            ->join('posko_pendaftarans', 'posko_pendaftarans.pendaftaran_id', '=', 'pendaftarans.id')
            ->join('poskos', 'poskos.id', '=', 'posko_pendaftarans.posko_id')
            ->orderBy('posko', 'asc')
            ->orderBy('mahasiswas.prodi', 'asc')
            ->orderBy('mahasiswas.nama', 'asc')
            ->paginate(10);

        $aspek = AspekPenilaian::whereHas('tahun_akademik', function ($db) {
            $db->where('status', 1);
        })
            ->orderBy('persen', 'asc')
            ->orderBy('aspek', 'asc')
            ->get();
        $datatable = view('dpl.nilai-datatable', ['data' => $peserta, 'aspek' => $aspek])->render();
        if ($request->ajax()) {
            return $datatable;
        }
        $posko = Posko::whereHas('dpl', function ($db) {
            $db->where('user_id', session('user')->id);
        })
            ->whereHas('tahun_akademik', function ($db) {
                $db->where('status', 1);
            })
            ->orderBy('nama', 'asc')
            ->get();
        return view('dpl.nilai', [
            'datatable' => $datatable,
            'posko' => $posko,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aspek = AspekPenilaian::whereHas('tahun_akademik', function ($db) {
            $db->where('status', 1);
        })
            ->orderBy('persen', 'asc')
            ->orderBy('aspek', 'asc')
            ->get();

        foreach ($request->all() as $key => $value) {
            if ($key !== '_token') {
                $n = explode('__', $key);
                $peserta = $n[1];
                $asp = $aspek[substr($n[0], 1) - 1] ?? null;
                $nilai = Nilai::where('pendaftaran_id', $peserta)->where('aspek', $asp->aspek)->first();
                if (!$nilai) {
                    $nilai = new Nilai;
                } else {
                    if ($value != '') {
                        $nilai->delete();
                    }
                }
                if ($value != '') {
                    $nilai->pendaftaran_id = $peserta;
                    $nilai->persen = $asp->persen;
                    $nilai->aspek = $asp->aspek;
                    $nilai->nilai = $value;
                    $nilai->save();
                }
            }
        }
        return Redirect::to(route('dpl.nilai'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
