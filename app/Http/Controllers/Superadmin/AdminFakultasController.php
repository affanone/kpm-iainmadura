<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IainApi;
use App\Models\TahunAkademik;
use App\Models\AdminFakultas;
use App\Models\User;
use App\Log;
use Yajra\DataTables\Facades\DataTables;

class AdminFakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $total_fakultas = IainApi::get('api/fakultas')->data->total;
        $fakultas = IainApi::get('api/fakultas?limit=' . $total_fakultas);

        $total_pegawai = IainApi::get('api/pegawai')->data->total;
        $pegawai = IainApi::get('api/pegawai?limit=' . $total_pegawai);

        $tahun_akademik = TahunAkademik::orderBy('status', 'desc')->get();

        return view('superadmin.admin_fakultas', [
            'fakultas' => $fakultas->data->data,
            'pegawai' => $pegawai->data->data,
            'tahun_akademik' => $tahun_akademik
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
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'fakultas' => 'required',
                'tahun' => 'required'
            ],
            [
                'nama.required' => 'Nama pegawai harus dipilih',
                'fakultas.required' => 'Fakultas harus dipilih',
                'tahun.required' => 'Tahun akademik harus dipilih'
            ]
        );

        $pegawai = explode('|', strip_tags($request->nama));
        $kode = $pegawai[0];
        $nama = $pegawai[1];
        $fakultas = strip_tags($request->fakultas);
        $tahun = strip_tags($request->tahun);

        $adm_fakultas = new AdminFakultas;
        $adm_fakultas->nama = $nama;
        $adm_fakultas->fakultas = $fakultas;
        $adm_fakultas->tahun_akademik_id = $tahun;

        $user = new User;
        $user->username = $kode;
        $user->access = '[3]';
        $user->save();
        $adm_fakultas->user()->associate($user);
        $adm_fakultas->save();

        Log::set("Melakukan tambah admin fakultas", "insert");

        $data = array(
            'icon' => 'success',
            'message' => 'Admin Fakultas : ' . $nama . ' Berhasil Disimpan'
        );

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = AdminFakultas::with(['user', 'tahun_akademik'])->get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" onClick="editAdmFakultas(\'' . $data->id . '\')" title="Edit Admin Fakultas"><i
                                class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onClick="hapusAdmFakultas(\'' . $data->id . '\')" title="Hapus Admin Fakultas"><i
                                class="fas fa-eraser"></i></button>
                    </div>';
                })
                ->editColumn('nama', function ($data) {
                    return $data->user->username . ' - ' . $data->nama;
                })
                ->editColumn('fakultas', function ($data) {
                    return 'Fakultas ' . explode('|', $data->fakultas)[1];
                })
                ->editColumn('tahun_akademik.tahun', function ($data) {
                    return $data->tahun_akademik->tahun . ' - ' . $data->tahun_akademik->semester;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adm_fakultas = AdminFakultas::with('user')->find($id);
        return response()->json($adm_fakultas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'fakultas' => 'required',
                'tahun' => 'required'
            ],
            [
                'nama.required' => 'Nama pegawai harus dipilih',
                'fakultas.required' => 'Fakultas harus dipilih',
                'tahun.required' => 'Tahun akademik harus dipilih'
            ]
        );

        $id = $request->id_admFakultas;
        $pegawai = explode('|', strip_tags($request->nama));
        $kode = $pegawai[0];
        $nama = $pegawai[1];
        $fakultas = strip_tags($request->fakultas);
        $tahun = strip_tags($request->tahun);

        $adm_fakultas = AdminFakultas::find($id);
        $adm_fakultas->nama = $nama;
        $adm_fakultas->fakultas = $fakultas;
        $adm_fakultas->tahun_akademik_id = $tahun;

        $user = User::find($adm_fakultas->user_id);
        $user->username = $kode;
        $user->update();
        $adm_fakultas->update();

        Log::set("Melakukan sunting admin fakultas", "update");

        $data = array(
            'icon' => 'success',
            'message' => 'Admin Fakultas Berhasil Diupdate'
        );

        return response()->json($data);
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
