<?php

namespace App\Http\Controllers\Reg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function __construct()
    {
        $this->min_sks = 100;
        $this->tidak_lulus = ["D", "E"];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return self::check_sks();
        return view("loader.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check_sks()
    {
        try {
            $sks = IainApi::get("mhs/sks");
            if ($sks->data->capaian) {
            } else {
                // data traskip sementara tidak ditemukan
                return response()->json([
                    "next" => false,
                    "message" =>
                        "SKS anda tidak ditemukan, silahkan laporkan kepada fakultas terkait masalah ini !!",
                ]);
            }
            return response()->json($sks);
        } catch (\Throwable $th) {
            // Kesalahan tidak ditemukan
            return response()->json([
                "next" => false,
                "message" =>
                    "Terdapat kesalahan pada saat pengecekan jumlah SKS !!",
            ]);
        }
    }

    public function check_nilai()
    {
        // matakuliah?tahun=2017&q=kpm&prod=0201

        $res = IainApi::get(
            "mahasiswa?nim=" . session("token_api")->user->username
        );
        if ($res->status) {
            if (count($res->data->data)) {
                $mhs = $res->data->data[0];
                $kur = $mhs->kurikulum->tahun;
                $prod = $mhs->prodi->id;
                $res = IainApi::get("matakuliah?kur=$kur&q=kpm&prod=$prod");
                if (count($res->data->data)) {
                    $mk = $res->data->data[0]->id;
                    $res = IainApi::get("mhs/nilai/?mk=$mk");
                    if ($res->data->nilai) {
                        $nilai = $res->data->nilai;
                        if (
                            in_array(
                                $res->data->nilai->huruf,
                                $this->tidak_lulus
                            )
                        ) {
                            // MK TIDAK LULUS
                            return response()->json([
                                "next" => true,
                                "message" => "Anda mengulang matakuliah KPM !!",
                            ]);
                        } else {
                            // MK SUDAH LULUS
                            return response()->json([
                                "next" => false,
                                "message" => "Anda sudah dinyatakan lulus !!",
                            ]);
                        }
                    } else {
                        // nilai tidak ditemukan
                        return response()->json([
                            "next" => true,
                            "message" => "Anda belum mengambil KPM !!",
                        ]);
                    }
                } else {
                    // mk tidak ditemukan
                    return response()->json([
                        "next" => false,
                        "message" => "Matakuliah KPM tidak ditemukan !!",
                    ]);
                }
                return $res->data;
            }
        } else {
            // mahasiswa tidak ditemukan
            return response()->json([
                "next" => false,
                "message" => "Data mahasiswa tidak ditemukan !!",
            ]);
        }
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
