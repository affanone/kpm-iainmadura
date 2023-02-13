<?php

namespace App\Http\Controllers\Reg;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\TahunAkademik;
use App\Models\User;

class RegisterController extends Controller
{
    function registrasi(Request $request)
    {
        // Validate form data
        $validator = Validator::make(
            $request->all(),
            [
                "alamat" => "required",
                "hp" => "required",
            ],
            [
                "alamat.required" => "Alamat saat ini harus diisi",
                "hp.required" => "Nomor HP/WA yang aktif harus diisi",
            ]
        );

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
        $m->user_id = $n->id;
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

        Auth::login($n);
        session()->push("register", true);
        \Log::set("Melakukan pendaftaran", "register");

        return Redirect::to("reg/kpm");
    }

    public function profil()
    {
        $nim = session("token_api")->user->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::where("status", 1)->first();
        return view("register.jenis-kpm", [
            "step" => 1,
            "data" => $mhs,
            "kpm" => $ta->kpm,
            "nama_kpm" =>
                "KPM IAIN Madura Semester $ta->semester $ta->tahun/" .
                ($ta->tahun + 1),
        ]);
    }

    public function kpm()
    {
        $nim = session("token_api")->user->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::with("kpm")
            ->where("status", 1)
            ->first();
        return $ta;
        return view("register.jenis-kpm", [
            "step" => 2,
            "data" => $mhs,
            "kpm" => $ta->kpm,
            "nama_kpm" =>
                "KPM IAIN Madura Semester $ta->semester $ta->tahun/" .
                ($ta->tahun + 1),
        ]);
    }
}
