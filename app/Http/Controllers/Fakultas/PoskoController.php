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
    public function index()
    {
        // mengambil tahun akademik yang aktif
        $admin = AdminFakultas::where('user_id', Auth::id())
            ->whereExists(function ($db) {
                $db->select('*')
                    ->from('tahun_akademiks')
                    ->whereRaw('tahun_akademiks.id = admin_fakultas.tahun_akademik_id')
                    ->where('tahun_akademiks.status', 1);
            })
            ->first();
        if (!$admin) {
            return view('fakultas.denied', [$message => 'Tidak ada tahun akademik yang diaktifkan oleh LP2M']);
        }

        $dpl = Dpl::where('fakultas', $admin->fakultas->id . '|' . $admin->fakultas->nama)->get();
        if (!count($dpl)) {
            return view('fakultas.denied', [$message => 'Tidak ada data DPL pada fakultas "' . $admin->fakultas->nama . '"']);
        }

        $referensi = env('API_SERVER') . '/api/pegawai?fak=' . $admin->fakultas->id;

        return view('fakultas.posko', [
            'fakultas' => $admin->fakultas->nama,
            'tahun' => $admin->tahun_akademik->semester . ' ' . $admin->tahun_akademik->tahun . '/' . ($admin->tahun_akademik->tahun + 1),
            'dpl' => $dpl,
            'referensi' => $referensi,
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

        \Log::set('Menambah data posko', 'add', $posko);

        return Redirect::to(route('fakultas.posko'));
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
