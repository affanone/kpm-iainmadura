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
        return view("loader.index");
    }

    public function validater()
    {
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
            $sks = IainApi::get("api/mhs/sks");
            if ($sks->data->capaian) {
                $total_sks = $sks->data->capaian->sks;
                if ($total_sks < $this->min_sks) {
                    // batas sks yang ditetapkan tidak memenuhi syarat
                    return response()->json([
                        "next" => false,
                        "message" => "Jumlah SKS tidak memenuhi syarat yang telah ditetapkan, batas minimal SKS adalah $this->min_sks SKS, sementara total SKS anda yang telah ditempuh adalah $total_sks SKS !!",
                    ]);
                } else {
                    return response()->json([
                        "next" => true,
                        "message" =>
                            "Jumlah SKS yang anda tempuh telah memenuhi syarat !!",
                    ]);
                }
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

    public function check_mk()
    {
        // matakuliah?tahun=2017&q=kpm&prod=0201

        $res = IainApi::get(
            "api/mahasiswa?nim=" . session("token_api")->user->username
        );
        if ($res->status) {
            if (count($res->data->data)) {
                $mhs = $res->data->data[0];
                $kur = $mhs->kurikulum->tahun;
                $prod = $mhs->prodi->id;
                $res = IainApi::get("api/matakuliah?kur=$kur&q=kpm&prod=$prod");
                if (count($res->data->data)) {
                    $mk = $res->data->data[0]->id;
                    $res = IainApi::get("api/mhs/nilai/?mk=$mk");
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
}
