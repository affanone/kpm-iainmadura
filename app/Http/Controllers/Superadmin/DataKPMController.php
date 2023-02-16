<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kpm;
use App\Models\Subkpm;
use Yajra\DataTables\Facades\DataTables;

class DataKPMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active_kpm = Kpm::with('tahun_akademik')
            ->whereHas('tahun_akademik', function ($query) {
                return $query->where('status', 1);
            })
            ->get();
        // return response()->json($active_kpm);
        return view("superadmin.data_kpm", ['data_kpm' => $active_kpm]);
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
                'jenis' => 'required',
                'nama' => 'required'
            ],
            [
                'jenis.required'    => 'Jenis KPM harus dipilih',
                'nama.required'    => 'Nama KPM harus diisi'
            ]
        );

        $jenis = strip_tags($request->jenis);
        $nama = strtoupper(strip_tags($request->nama));
        $deskripsi = strip_tags($request->deskripsi);

        $unik = uniqid();
        $config = [
            "upload" => [
                [
                    "id" => "krs" . $unik,
                    "name" => "krs" . $unik,
                    "label" => "Bukti KRS",
                    "deskripsi" => "Harap Upload KRS terbaru anda",
                    "validator" => [
                        [
                            "rule" => "required",
                            "message" => "Bukti KRS Harus Diisi"
                        ]
                    ],
                    "format" => [
                        "jgp",
                        "pdf"
                    ]
                ],
                [
                    "id" => "rekom" . $unik,
                    "name" => "rekom" . $unik,
                    "label" => "Bukti KRS",
                    "deskripsi" => "Harap uload rekomendasi dari dekan",
                    "validator" => [
                        [
                            "rule" => "required",
                            "message" => "Bukti KRS Harus Diisi"
                        ]
                    ],
                    "format" => [
                        "jgp",
                        "pdf"
                    ]
                ]
            ],
            "validate" => false
        ];

        $kpm = new Subkpm;
        $kpm->kpm_id = $jenis;
        $kpm->nama = $nama;
        $kpm->deskripsi = $deskripsi;
        $kpm->config = json_encode($config);
        $kpm->save();

        $data = array(
            'icon' => 'success',
            'message' => 'Data KPM : ' . $nama . ' Berhasil Disimpan'
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
            $data = Subkpm::with('kpm', 'kpm.tahun_akademik')->get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" onClick="editDataKPM(\'' . $data->id . '\')" title="Edit Data KPM"><i
                                class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onClick="hapusDataKPM(\'' . $data->id . '\')" title="Hapus Data KPM"><i
                                class="fas fa-eraser"></i></button>
                    </div>';
                })
                ->editColumn('kpm.nama', function ($data) {
                    return $data->kpm->nama . ' (' . $data->kpm->tahun_akademik->tahun . ' - ' . $data->kpm->tahun_akademik->semester . ')';
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
        $kpm = Subkpm::find($id);
        return response()->json($kpm);
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
                'jenis' => 'required',
                'nama' => 'required'
            ],
            [
                'jenis.required'    => 'Jenis KPM harus dipilih',
                'nama.required'    => 'Nama KPM harus diisi'
            ]
        );

        $id = $request->id_dataKPM;
        $jenis = strip_tags($request->jenis);
        $nama = strip_tags($request->nama);
        $deskripsi = strip_tags($request->deskripsi);

        $kpm = Subkpm::find($id);
        $kpm->kpm_id = $jenis;
        $kpm->nama = $nama;
        $kpm->deskripsi = $deskripsi;
        $kpm->update();

        $data = array(
            'icon' => 'success',
            'message' => 'Data KPM ' . $nama . ' Berhasil Diupdate'
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
        $kpm = Subkpm::find($id);

        $data = array();
        try {
            $proc = $kpm->delete();
            if ($proc) {
                $data['icon'] = 'success';
                $data['title'] = 'Berhasil';
                $data['message'] = 'Data KPM : ' . $kpm->nama . ' Berhasil Dihapus';
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $error = $e->errorInfo;
            $data['icon'] = 'error';
            $data['title'] = 'Gagal';
            $data['message'] = str_contains($error[2], 'constraint') ? 'Data KPM : ' . $kpm->nama . ' sedang digunakan' : 'Ada Kesalahan';
        }
        return response()->json($data);
    }
}
