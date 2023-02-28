<?php

namespace App\Http\Controllers\Dpl;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posko = Pendaftaran::whereHas('subkpm.kpm.tahun_akademik', function ($db) {
            $db->where('status', 1);
        })
            ->whereExists(function ($db) {
                $db->select('*')
                    ->from('poskos')
                    ->whereRaw('poskos.tahun_akademik_id = pendaftarans.tahun_akademik_id')

                    ->whereExists(function ($db) {
                        $db->select('*')
                            ->from('dpls')
                            ->whereRaw('dpls.id = poskos.dpl_id')
                            ->where('dpls.user_id', session('user')->id);
                    });
            })
            ->get();
        return $posko;
        return view('dpl.nilai', [
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
