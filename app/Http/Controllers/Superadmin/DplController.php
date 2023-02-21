<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Log;
use App\Models\Dpl;
use Illuminate\Http\Request;
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
                                <span class="badge badge-dark">' . $data->nip . '</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                NIDN
                                <span class="badge badge-dark">' . $data->nidn . '</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Jenis Kelamin
                                <span class="badge badge-dark">' . (is_null($data->kelamin) ? '-' : ($data->kelamin == 'L' ? 'Laki-laki' : 'Perempuan')) . '</span>
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
        $dpl = Dpl::find($id);
        return response()->json($dpl);
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
                'kelamin' => 'required',
                'hp' => 'required',
                'alamat' => 'required',
            ],
            [
                'kelamin.required' => 'Jenis kelamin harus dipilih',
                'hp.required' => 'Nomor HP harus diisi',
                'alamat.required' => 'Alamat harus diisi',
            ]
        );

        $id = $request->id_dpl;
        $nama = $request->nama;
        $kelamin = $request->kelamin;
        $hp = str_replace(array('(', ')', '-', '_', ' '), '', strip_tags($request->hp));
        $alamat = strip_tags($request->alamat);

        $dpl = Dpl::find($id);
        $dpl->kelamin = $kelamin;
        $dpl->hp = $hp;
        $dpl->alamat = $alamat;
        $dpl->update();

        Log::set("Melakukan sunting data DPL", "update");

        $data = array(
            'icon' => 'success',
            'message' => 'DPL : ' . $nama . ' Berhasil Diupdate',
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
        $dpl = Dpl::find($id);

        $data = array();
        try {
            $proc = $dpl->delete();
            if ($proc) {
                $data['icon'] = 'success';
                $data['title'] = 'Berhasil';
                $data['message'] = 'DPL : ' . $dpl->nama . ' Berhasil Dihapus';

                Log::set("Melakukan hapus data DPL", "delete");
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $error = $e->errorInfo;
            $data['icon'] = 'error';
            $data['title'] = 'Gagal';
            $data['message'] = str_contains($error[2], 'constraint') ? 'DPL : ' . $dpl->nama . ' tidak dapat dihapus, data digunakan' : 'Ada Kesalahan';
        }
        return response()->json($data);
    }
}
