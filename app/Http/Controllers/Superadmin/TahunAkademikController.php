<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use DataTables;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('register.tahun_akademik');
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
                'tahun' => 'required|numeric|unique:tahun_akademiks',
                'semester' => 'required'
            ],
            [
                'tahun.required' => 'Tahun harus diisi',
                'tahun.numeric' => 'Tahun harus diisi angka',
                'semester.required' => 'Semester harus dipilih'
            ]
        );

        $tahun = strip_tags($request->tahun);
        $semester = strtoupper(strip_tags($request->semester));
        $status = strip_tags($request->status) == 'on' ? 1 : 0;

        if ($status == 1) {
            TahunAkademik::query()->update(['status' => 0]);
        }

        $ta = new TahunAkademik;
        $ta->tahun = $tahun;
        $ta->semester = $semester;
        $ta->status = $status;
        $ta->save();

        $data = array(
            'icon' => 'success',
            'message' => 'Tahun Akademik ' . $tahun . ' Berhasil Disimpan'
        );
        echo json_encode($data);
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
            $data = TahunAkademik::get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" onClick="editThnAkademik(\'' . $data->id . '\')" title="Edit Tahun Akademik"><i
                                class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onClick="hapusThnAkademik(\'' . $data->id . '\')" title="Hapus Tahun Akademik"><i
                                class="fas fa-eraser"></i></button>
                    </div>';
                })
                ->editColumn('status', function ($data) {
                    $badge = 'badge badge-danger';
                    $status = $data->status == 1 ? 'Aktif' : 'Tidak Aktif';
                    if ($data->status == 1) {
                        $badge = 'badge badge-success';
                    }
                    return '<span class="' . $badge . '">' . $status . '</span>';
                })
                ->rawColumns(['status', 'action'])
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
        $data = TahunAkademik::find($id);

        return response()->json($data);
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
