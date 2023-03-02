<?php

namespace App\Http\Controllers\Fakultas;

use App\Http\Controllers\Controller;
use App\IainApi;
use App\Log;
use App\Models\AdminFakultas;
use App\Models\Pendaftaran;
use App\Models\Posko;
use App\Models\PoskoPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenempatanPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $posko)
    {
        $id_fakultas = AdminFakultas::select('fakultas')
            ->where('user_id', auth()->user()->id)
            ->first()->fakultas->id;

        $total_prodi = IainApi::get('api/prodi')->data->total;
        $dt_prodi = IainApi::get('api/prodi?limit=' . $total_prodi);
        $expected = array_filter($dt_prodi->data->data, function ($item) use ($id_fakultas) {
            return ($item->fakultas->id == $id_fakultas);
        });
        $prodi = array_values($expected);

        $posko = Posko::where('id', $posko)->first();

        $mahasiswa = Pendaftaran::select('pendaftarans.*', DB::raw("IFNULL(posko_pendaftarans.id, 0) AS cek"))->with(['mahasiswa', 'subkpm'])
            ->where('status', 3)
            ->whereHas('mahasiswa', function ($q) {
                return $q->where('fakultas', function ($query) {
                    return $query->select('fakultas')
                        ->from('admin_fakultas')
                        ->where('user_id', auth()->user()->id);
                });
            })
            ->join('mahasiswas', 'mahasiswas.id', '=', 'pendaftarans.mahasiswa_id')
            ->leftJoin('posko_pendaftarans', function ($db) use ($posko) {
                $db->on('posko_pendaftarans.pendaftaran_id', '=', 'pendaftarans.id')
                    ->whereExists(function ($db) use ($posko) {
                        $db->select('*')
                            ->from('poskos')
                            ->where('poskos.id', $posko->id);
                    });
            })
            ->whereNotExists(function ($db) use ($posko) {
                $db->select('*')
                    ->from('posko_pendaftarans')
                    ->whereRaw('posko_pendaftarans.pendaftaran_id = pendaftarans.id')
                    ->where('posko_pendaftarans.posko_id', '<>', $posko->id);
            })
            ->when($request->cari, function ($db) use ($request) {
                return $db->whereHas('mahasiswa', function ($q) use ($request) {
                    return $q->where(function ($db) use ($request) {
                        $db->where('fakultas', 'like', "%$request->cari%");
                        $db->orWhere('nama', 'like', "%$request->cari%");
                        $db->orWhere('prodi', 'like', "%$request->cari%");
                        $db->orWhere('nim', 'like', "%$request->cari%");
                        $db->orWhere('alamat', 'like', "%$request->cari%");
                    });
                });
            })
            ->when($request->prodi, function ($db) use ($request) {
                return $db->whereHas('mahasiswa', function ($q) use ($request) {
                    return $q->where('prodi', 'like', "%$request->prodi%");
                });
            })
            ->orderBy('mahasiswas.prodi', 'asc')
            ->orderBy('mahasiswas.nama', 'asc')
            ->get();
        // return $mahasiswa;
        // return view('fakultas.penempatan-v2');

        if ($request->ajax()) {
            return $mahasiswa;
        }

        return view('fakultas.penempatan_peserta', [
            'mahasiswa' => $mahasiswa,
            'prodi' => $prodi,
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
        $posko = $request->id_posko;
        $mahasiswa = $request->id_peserta;

        $cek_peserta = PoskoPendaftaran::where('pendaftaran_id', $mahasiswa)->first();

        if (!$cek_peserta) {
            $penempatan = new PoskoPendaftaran;
            $penempatan->posko_id = $posko;
            $penempatan->pendaftaran_id = $mahasiswa;
            $penempatan->save();

            Log::set("Menambah peserta ke posko", "insert", $penempatan);
        }

        $data = array(
            'icon' => 'success',
            'message' => 'Peserta Berhasil Ditambahkan ke Posko',
        );

        return response()->json($data);
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
