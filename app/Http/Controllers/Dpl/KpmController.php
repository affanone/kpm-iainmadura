<?php

namespace App\Http\Controllers\Dpl;

use App\Http\Controllers\Controller;
use App\Models\Posko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KpmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posko = Posko::select('poskos.*')
            ->addSelect(DB::raw('ifnull(pp.total,0) as total'))
            ->whereExists(function ($db) {
                $db->select('*')
                    ->from('dpls')
                    ->whereRaw('dpls.id = poskos.dpl_id')
                    ->where('dpls.user_id', session('user')->id);
            })
            ->leftJoin(DB::raw('(
                SELECT pp.posko_id, COUNT(pp.id) AS total
                FROM posko_pendaftarans pp
                GROUP BY pp.posko_id
              )pp'), DB::raw('pp.posko_id'), '=', DB::raw('poskos.id'))
            ->orderBy('nama', 'asc')
            ->paginate(10);
        $dpl = Dpl::where()
        $datatable = view('dpl.datatable', ['data' => $posko])->render();
        $tahun_akademiks = Posko::select('tahun_akademik_id')->where('fakultas', $admin->fakultas->id . '|' . $admin->fakultas->nama)->groupBy('tahun_akademik_id')->get();
        if ($request->ajax()) {
            return $datatable;
        }
        return view('dpl.kpm', [
            'datatable' => $datatable,
            'tahun_akademiks' => $tahun_akademiks,
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
