<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IainApi;
use App\Models\TahunAkademik;

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

        $nama = strip_tags($request->nama);
        $fakultas = strip_tags($request->fakultas);
        $tahun = strip_tags($request->tahun);
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
