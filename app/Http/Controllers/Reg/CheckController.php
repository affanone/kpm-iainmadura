<?php

namespace App\Http\Controllers\Reg;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Mahsiswa;

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
        $nim = session("token_api")->user->username;
        $res = \IainApi::get("api/mahasiswa?nim=$nim");
        return view("loader.index", [
            "nama" => ucwords(strtolower($res->data->data[0]->nama)),
        ]);
    }

    public function registrasi()
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            "alamat" => "required",
            "hp" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nim = session("token_api")->user->username;
        $res = \IainApi::get("api/mahasiswa?nim=$nim");
        $mhs = $res->data->data[0];

        $n = new User();
        $n->username = session("token_api")->user->username;
        $n->email = session("token_api")->user->email;
        $n->email_verified_at = now();
        $n->access = "[2]";
        $n->save();

        $m = new Mahasiswa();
        $m->nim = $mhs->nim;
        $m->nama = $mhs->nama;
        $m->kelamin = $mhs->kelamin;
        $m->prodi =
            $mhs->prodi->id . "|" . $mhs->prodi->long . "|" . $mhs->prodi->sort;
        $m->fakultas =
            $mhs->prodi->fakultas->id . "|" . $mhs->prodi->fakultas->nama;
        $m->hp = $request->hp;
        $m->alamat = $request->alamat;
        $m->save();

        \Log::set("Melakukan pendaftaran", "register");
    }

    public function valid()
    {
        if (session("valid_status") == 3) {
            $nim = session("token_api")->user->username;
            $res = \IainApi::get("api/mahasiswa?nim=$nim");
            $mhs = $res->data->data[0];
            return redirect()->route("pendaftaran.kpm");
            // return $mhs;
            // return view('')
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
        $nim = session("token_api")->user->username;
        $res = \IainApi::get("api/mahasiswa?nim=$nim");
        if (count($res->data->data)) {
            $ket = $res->data->data[0]->status->keterangan;
            if ($ket == "AKTIF") {
                session()->flash("valid_status", 1);
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
                    session()->flash(
                        "valid_status",
                        session("valid_status") + 1
                    );
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
            "api/mahasiswa?nim=" . session("token_api")->user->username
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
                            session()->flash(
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
                        session()->flash(
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
