<?php

namespace App\Http\Controllers\Fakultas;

use App\Http\Controllers\Controller;
use App\Models\AdminFakultas;
use App\Models\Dpl;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PoskoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $posko = null)
    {
        // mengambil tahun akademik yang aktif
        $master = Posko::when($request->cari, function ($db, $n) {
            $db->where(function ($db) use ($n) {
                $db->where('fakultas', 'like', "%$n%");
                $db->orWhere('nama', 'like', "%$n%");
                $db->orWhere('alamat', 'like', "%$n%");
                $db->orWhere('deskripsi', 'like', "%$n%");
            });
        })
            ->when($request->tahun, function ($db, $n) {
                $db->where('tahun_akademik_id', $n);
            })
            ->paginate(10);
        $datatable = view('fakultas.table_posko', ['data' => $master])->render();
        if ($request->ajax()) {
            return $datatable;
        }

        $admin = AdminFakultas::where('user_id', Auth::id())
            ->whereExists(function ($db) {
                $db->select('*')
                    ->from('tahun_akademiks')
                    ->whereRaw('tahun_akademiks.id = admin_fakultas.tahun_akademik_id')
                    ->where('tahun_akademiks.status', 1);
            })
            ->first();
        if (!$admin) {
            return view('fakultas.denied', ['message' => 'Tidak ada tahun akademik yang diaktifkan oleh LP2M']);
        }

        $dpls = Dpl::where('fakultas', $admin->fakultas->id . '|' . $admin->fakultas->nama)->get();
        $tahun_akademiks = Posko::select('tahun_akademik_id')->where('fakultas', $admin->fakultas->id . '|' . $admin->fakultas->nama)->groupBy('tahun_akademik_id')->get();
        if (!count($dpls)) {
            return view('fakultas.denied', ['message' => 'Tidak ada data DPL pada fakultas "' . $admin->fakultas->nama . '"']);
        }

        $referensi = env('API_SERVER') . '/api/pegawai?fak=' . $admin->fakultas->id;

        $data = [
            'fakultas' => $posko->fakultas->nama ?? $admin->fakultas->nama,
            'tahun' => $posko ? $posko->tahun_akademik->semester . ' ' . $posko->tahun_akademik->tahun . '/' . ($posko->tahun_akademik->tahun + 1) : $admin->tahun_akademik->semester . ' ' . $admin->tahun_akademik->tahun . '/' . ($admin->tahun_akademik->tahun + 1),
            'tahun_akademiks' => $tahun_akademiks,
            'dpls' => $dpls,
            'nama' => $posko->nama ?? '',
            'dpl' => $posko->dpl_id ?? '',
            'alamat' => $posko->alamat ?? '',
            'deskripsi' => $posko->deskripsi ?? '',
            'referensi' => $referensi,
            'edit' => ($posko ? true : ($request->add == 1 ? true : false)),
            'datatable' => $datatable,
        ];
        return view('fakultas.posko', $data);
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
                'alamat' => 'required',
                'dpl' => 'required',
            ],
            [
                'nama.required' => 'Nama atau label posko harus diisi',
                'alamat.required' => 'Alamat posko harus diisi',
                'dpl.required' => 'DPL harus ditentukan',
            ]
        );

        $admin = AdminFakultas::where('user_id', Auth::id())
            ->whereExists(function ($db) {
                $db->select('*')
                    ->from('tahun_akademiks')
                    ->whereRaw('tahun_akademiks.id = admin_fakultas.tahun_akademik_id')
                    ->where('tahun_akademiks.status', 1);
            })
            ->first();

        $posko = new Posko;
        $posko->fakultas = $admin->fakultas->id . '|' . $admin->fakultas->nama;
        $posko->tahun_akademik_id = $admin->tahun_akademik_id;
        $posko->nama = $request->nama;
        $posko->dpl_id = $request->dpl;
        $posko->alamat = $request->alamat;
        $posko->deskripsi = $request->deskripsi ?? null;
        $posko->save();

        \Log::set('Melakukan tambah posko KPM', 'insert', $posko);

        return Redirect::to(route('fakultas.posko'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $posko = Posko::find($id);
        return $this->index($request, $posko);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posko = Posko::find($id);
        return $this->index(null, $posko);
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
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'alamat' => 'required',
                'dpl' => 'required',
            ],
            [
                'nama.required' => 'Nama atau label posko harus diisi',
                'alamat.required' => 'Alamat posko harus diisi',
                'dpl.required' => 'DPL harus ditentukan',
            ]
        );

        $admin = AdminFakultas::where('user_id', Auth::id())
            ->whereExists(function ($db) {
                $db->select('*')
                    ->from('tahun_akademiks')
                    ->whereRaw('tahun_akademiks.id = admin_fakultas.tahun_akademik_id')
                    ->where('tahun_akademiks.status', 1);
            })
            ->first();

        $posko = Posko::find($id);
        $poskoBefore = $posko;
        $posko->fakultas = $admin->fakultas->id . '|' . $admin->fakultas->nama;
        $posko->tahun_akademik_id = $admin->tahun_akademik_id;
        $posko->nama = $request->nama;
        $posko->dpl_id = $request->dpl;
        $posko->alamat = $request->alamat;
        $posko->deskripsi = $request->deskripsi ?? null;
        $posko->save();

        \Log::set('Melakukan sunting posko KPM', 'update', $poskoBefore, $posko);

        return Redirect::to(route('fakultas.posko'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posko = Posko::find($id);
        Posko::destroy($id);
        \Log::set('Melakukan hapus posko KPM', 'delete', $posko);
        return Redirect::to(route('fakultas.posko'));
    }
}
