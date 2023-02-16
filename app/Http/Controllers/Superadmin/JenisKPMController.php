<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use App\Models\Kpm;
use Yajra\DataTables\Facades\DataTables;

class JenisKPMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ta = TahunAkademik::orderBy('status', 'desc')->get();
        return view("superadmin.jenis_kpm", ['ta' => $ta]);
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
                'tahun' => 'required',
                'jenis' => 'required'
            ],
            [
                'tahun.required'    => 'Tahun Akademik harus dipilih',
                'jenis.required'    => 'Jenis KPM harus diisi'
            ]
        );

        $tahun = strip_tags($request->tahun);
        $jenis = strtoupper(strip_tags($request->jenis));
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

        $kpm = new Kpm;
        $kpm->tahun_akademik_id = $tahun;
        $kpm->nama = $jenis;
        $kpm->deskripsi = $deskripsi;
        $kpm->config = json_encode($config);
        $kpm->save();

        $data = array(
            'icon' => 'success',
            'message' => 'Jenis KPM : ' . $jenis . ' Berhasil Disimpan'
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
            $data = KPM::with('tahun_akademik')->get();

            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" onClick="editJenisKPM(\'' . $data->id . '\')" title="Edit Jenis KPM"><i
                                class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onClick="hapusJenisKPM(\'' . $data->id . '\')" title="Hapus Jenis KPM"><i
                                class="fas fa-eraser"></i></button>
                    </div>';
                })
                ->editColumn('tahun_akademik.tahun', function ($data) {
                    return $data->tahun_akademik->tahun . ' - ' . $data->tahun_akademik->semester;
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
        $data = KPM::find($id);
        return response()->json($data);
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
                'tahun' => 'required',
                'jenis' => 'required'
            ],
            [
                'tahun.required'    => 'Tahun Akademik harus dipilih',
                'jenis.required'    => 'Jenis KPM harus diisi'
            ]
        );

        $id = $request->id_jenisKPM;
        $tahun = strip_tags($request->tahun);
        $jenis = strtoupper(strip_tags($request->jenis));
        $deskripsi = strip_tags($request->deskripsi);

        $kpm = Kpm::find($id);
        $kpm->tahun_akademik_id = $tahun;
        $kpm->nama = $jenis;
        $kpm->deskripsi = $deskripsi;
        $kpm->update();

        $data = array(
            'icon' => 'success',
            'message' => 'Jenis KPM ' . $jenis . ' Berhasil Diupdate'
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
        $kpm = Kpm::find($id);

        $data = array();
        try {
            $proc = $kpm->delete();
            if ($proc) {
                $data['icon'] = 'success';
                $data['title'] = 'Berhasil';
                $data['message'] = 'Jenis KPM : ' . $kpm->nama . ' Berhasil Dihapus';
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $error = $e->errorInfo;
            $data['icon'] = 'error';
            $data['title'] = 'Gagal';
            $data['message'] = str_contains($error[2], 'constraint') ? 'Jenis KPM : ' . $kpm->nama . ' sedang digunakan' : 'Ada Kesalahan';
        }
        return response()->json($data);
    }
}
