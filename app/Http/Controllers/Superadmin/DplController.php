<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dpl;
use Yajra\DataTables\Facades\DataTables;

class DplController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('superadmin.dpl');
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
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = Dpl::get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" onClick="editDPL(\'' . $data->id . '\')" title="Edit DPL"><i
                                class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onClick="hapusDPL(\'' . $data->id . '\')" title="Hapus DPL"><i
                                class="fas fa-eraser"></i></button>
                    </div>';
                })
                ->editColumn('nama', function ($data) {
                    return '
                    <button class="btn btn-primary btn-sm mb-2" type="button" data-toggle="collapse" data-target="#' . $data->id . '" aria-expanded="false" aria-controls="' . $data->id . '">' . $data->nama . '</button>
                    <div class="collapse" id="' . $data->id . '">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                NIP
                                <span class="badge badge-primary">' . $data->nip . '</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                NIDN
                                <span class="badge badge-primary">' . $data->nidn . '</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Jenis Kelamin
                                <span class="badge badge-primary">' . (is_null($data->kelamin) ? '-' : ($data->kelamin == 'L' ? 'Laki-laki' : 'Perempuan'))  . '</span>
                            </li>
                        </ul>
                    </div>
                    ';
                })
                ->editColumn('prodi', function ($data) {
                    return $data->prodi->long . ' (' . $data->prodi->fakultas->nama . ')';
                })
                ->rawColumns(['nama', 'action'])
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