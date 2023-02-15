<?php

namespace App\Http\Controllers\Reg;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;

class CheckController extends Controller
{
    protected $min_sks;
    protected $tidak_lulus;

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
        $nim = session("token_api")->user->kode;
        $res = \IainApi::get("api/mahasiswa?kode=$nim");
        return view("loader.index", [
            "nama" => ucwords(strtolower($res->data->data[0]->nama)),
        ]);
    }

    public function valid()
    {
        if (session("valid_status") == 3) {
            $nim = session("token_api")->user->kode;
            $res = \IainApi::get("api/mahasiswa?kode=$nim");
            $mhs = $res->data->data[0];
            $ta = TahunAkademik::where("status", 1)->first();
            if ($ta && count($ta->kpm)) {
                return view("register.data-diri", [
                    "step" => 0,
                    "mhs" => $mhs,
                    "hp" => "",
                    "alamat" => "",
                    "nama_kpm" =>
                        "KPM IAIN Madura Semester $ta->semester $ta->tahun/" .
                        ($ta->tahun + 1),
                ]);
            } else {
                \IainApi::get("api/auth/logout");
                Auth::logout();
                session()->flush();
                return Redirect::to("signin")
                    ->withErrors(
                        "Mohon maaf, saat ini belum ada pendaftaran KPM yang tersedia",
                        "login"
                    )
                    ->withInput();
            }
        } else {
            \IainApi::get("api/auth/logout");
            Auth::logout();
            session()->flush();
            return Redirect::to("signin")
                ->withErrors(
                    "Tidak dapat melakukan pendaftaran karena dianggap ILEGAL",
                    "login"
                )
                ->withInput();
        }
    }

    public function check_aktif()
    {
        $nim = session("token_api")->user->kode;
        $res = \IainApi::get("api/mahasiswa?kode=$nim");
        if (count($res->data->data)) {
            $ket = $res->data->data[0]->status->keterangan;
            if ($ket == "AKTIF") {
                session()->put("valid_status", 1);
                return response()->json([
                    "next" => true,
                    "message" => "Status anda \"$ket\", sehingga dapat melanjutkan",
                ]);
            } else {
                return response()->json([
                    "next" => false,
                    "message" => "Status anda sedang \"$ket\"",
                ]);
            }
        } else {
            return response()->json([
                "next" => false,
                "message" => "Data mahasiswa tidak ditemukan !!",
            ]);
        }
    }

    public function check_sks()
    {
        try {
            $sks = \IainApi::get("api/mhs/sks");
            if ($sks->data->capaian) {
                $total_sks = $sks->data->capaian->sks;
                if ($total_sks < $this->min_sks) {
                    // batas sks yang ditetapkan tidak memenuhi syarat
                    return response()->json([
                        "next" => false,
                        "message" => "Jumlah SKS tidak memenuhi syarat yang telah ditetapkan, batas minimal SKS adalah $this->min_sks SKS, sementara total SKS anda yang telah ditempuh adalah $total_sks SKS!!",
                    ]);
                } else {
                    session()->put("valid_status", session("valid_status") + 1);
                    return response()->json([
                        "next" => true,
                        "message" =>
                            "Jumlah SKS yang anda tempuh telah memenuhi syarat!!",
                    ]);
                }
            } else {
                // data traskip sementara tidak ditemukan
                return response()->json([
                    "next" => false,
                    "message" =>
                        "SKS anda tidak ditemukan, silahkan laporkan kepada fakultas terkait masalah ini!!",
                ]);
            }
            return response()->json($sks);
        } catch (\Throwable $th) {
            // Kesalahan tidak ditemukan
            return response()->json([
                "next" => false,
                "message" =>
                    "Terdapat kesalahan pada saat pengecekan jumlah SKS!!",
            ]);
        }
    }

    public function check_mk()
    {
        // matakuliah?tahun=2017&q=kpm&prod=0201

        $res = \IainApi::get(
            "api/mahasiswa?kode=" . session("token_api")->user->kode
        );
        if ($res->status) {
            if (count($res->data->data)) {
                $mhs = $res->data->data[0];
                $kur = $mhs->kurikulum->tahun;
                $prod = $mhs->prodi->id;
                $res = \IainApi::get(
                    "api/matakuliah?kur=$kur&q=kpm&prod=$prod"
                );
                if (count($res->data->data)) {
                    $mk = $res->data->data[0]->id;
                    $res = \IainApi::get("api/mhs/nilai/?mk=$mk");
                    if ($res->data->nilai) {
                        $nilai = $res->data->nilai;
                        if (
                            in_array(
                                $res->data->nilai->huruf,
                                $this->tidak_lulus
                            )
                        ) {
                            // MK TIDAK LULUS
                            session()->put(
                                "valid_status",
                                session("valid_status") + 1
                            );
                            return response()->json([
                                "next" => true,
                                "message" => "Anda mengulang matakuliah KPM!!!",
                            ]);
                        } else {
                            // MK SUDAH LULUS
                            return response()->json([
                                "next" => false,
                                "message" => "Anda sudah dinyatakan lulus!!!",
                            ]);
                        }
                    } else {
                        // nilai tidak ditemukan
                        session()->put(
                            "valid_status",
                            session("valid_status") + 1
                        );
                        return response()->json([
                            "next" => true,
                            "message" => "Anda belum mengambil KPM!!!",
                        ]);
                    }
                } else {
                    // mk tidak ditemukan
                    return response()->json([
                        "next" => false,
                        "message" => "Matakuliah KPM tidak ditemukan!!!",
                    ]);
                }
                return $res->data;
            }
        } else {
            // mahasiswa tidak ditemukan
            return response()->json([
                "next" => false,
                "message" => "Data mahasiswa tidak ditemukan!!!",
            ]);
        }
    }
}
