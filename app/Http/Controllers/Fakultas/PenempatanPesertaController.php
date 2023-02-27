<?php

namespace App\Http\Controllers\Fakultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\AdminFakultas;
use App\Models\Posko;
use App\IainApi;

class PenempatanPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($posko)
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

        $posko = Posko::where('fakultas', $id_fakultas)
            ->get();

        $mahasiswa = Mahasiswa::with(['pendaftaran', 'pendaftaran.subkpm'])
            ->where('fakultas', function ($query) {
                return $query->select('fakultas')
                    ->from('admin_fakultas')
                    ->where('user_id', auth()->user()->id);
            })
            ->whereHas('pendaftaran', function ($query) {
                return $query->where('status', 3);
            })
            ->get();

        return view('fakultas.penempatan_peserta', [
            'mahasiswa' => $mahasiswa,
            'prodi' => $prodi,
            'posko' => $posko
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
        //
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
