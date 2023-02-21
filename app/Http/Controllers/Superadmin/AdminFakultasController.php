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

        $user = User::where('username', $kode)->first();
        if ($user) {
            $access = $user->access;
            if (!in_array(3, $access)) {
                array_push($access, 3);
                $user->access = json_encode($access);
                $user->update();
            }
        } else {
            $user = new User;
            $user->username = $kode;
            $user->access = '[3]';
            $user->save();
        }
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

        $adm_fakultas = AdminFakultas::with('user')->find($id);

        if (in_array(3, $adm_fakultas->user->access) && count($adm_fakultas->user->access) > 1) {
            $active_user = User::where('id', $adm_fakultas->user_id)->first();
            $access = $active_user->access;
            if (($key = array_search(3, $access)) !== false) {
                unset($access[$key]);
            }
            $active_user->access = json_encode($access);
            $active_user->update();

            $adm_fakultas->delete();

            $user_new = new User;
            $user_new->username = $kode;
            $user_new->access = '[3]';
            $user_new->save();

            $adm_fakultas_new = new AdminFakultas;
            $adm_fakultas_new->nama = $nama;
            $adm_fakultas_new->fakultas = $fakultas;
            $adm_fakultas_new->tahun_akademik_id = $tahun;
            $adm_fakultas_new->user()->associate($user_new);
            $adm_fakultas_new->save();
        } else {
            $adm_fakultas->nama = $nama;
            $adm_fakultas->fakultas = $fakultas;
            $adm_fakultas->tahun_akademik_id = $tahun;

            $user = User::where('username', $kode)->first();
            if ($user) {
                $access = $user->access;
                if (!in_array(3, $access)) {
                    array_push($access, 3);
                    $user->access = json_encode($access);
                    $user->update();

                    $user_del = User::where('id', $adm_fakultas->user_id);
                    $user_del->delete();

                    $adm_fakultas->user_id = $user->id;
                    $adm_fakultas->update();
                }
            } else {
                $user = User::find($adm_fakultas->user_id);
                $user->username = $kode;
                $user->update();
            }
            $adm_fakultas->update();
        }

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
    public function destroy(Request $request)
    {
        $id = $request->id;
        $admin_fakultas = AdminFakultas::with('user')->find($id);

        $data = array();
        if (count($admin_fakultas->user->access) > 1) {
            $access = $admin_fakultas->user->access;
            if (($key = array_search(3, $access)) !== false) {
                unset($access[$key]);
            }
            $user = User::where('id', $admin_fakultas->user_id)->first();
            $user->access = json_encode($access);
            $user->update();

            try {
                $proc = $admin_fakultas->delete();
                if ($proc) {
                    $data['icon'] = 'success';
                    $data['title'] = 'Berhasil';
                    $data['message'] = 'Admin Fakultas : ' . $admin_fakultas->nama . ' Berhasil Dihapus';

                    Log::set("Melakukan hapus admin fakultas", "delete");
                }
            } catch (\Illuminate\Database\QueryException $e) {
                $error = $e->errorInfo;
                $data['icon'] = 'error';
                $data['title'] = 'Gagal';
                $data['message'] = str_contains($error[2], 'constraint') ? 'Admin Fakultas : ' . $admin_fakultas->nama . ' sedang digunakan' : 'Ada Kesalahan';
            }
        } else {
            $user = User::where('id', $admin_fakultas->user_id)->first();
            try {
                $del_user = $user->delete();
                $del_admFakultas = $admin_fakultas->delete();
                if ($del_user && $del_admFakultas) {
                    $data['icon'] = 'success';
                    $data['title'] = 'Berhasil';
                    $data['message'] = 'Admin Fakultas : ' . $admin_fakultas->nama . ' Berhasil Dihapus';

                    Log::set("Melakukan hapus admin fakultas", "delete");
                }
            } catch (\Illuminate\Database\QueryException $e) {
                $error = $e->errorInfo;
                $data['icon'] = 'error';
                $data['title'] = 'Gagal';
                $data['message'] = str_contains($error[2], 'constraint') ? 'Admin Fakultas : ' . $admin_fakultas->nama . ' sedang digunakan' : 'Ada Kesalahan';
            }
        }

        return response()->json($data);
    }
}
