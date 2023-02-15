<?php

namespace App\Http\Controllers\Reg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Dpl;

class DplController extends Controller
{
    public function profil(Request $request)
    {
        $kode = session("token_api")->user->kode;
        $res = \IainApi::get("api/dosen?kode=$kode");
        if (!count($res->data->data)) {
            return "Data anda tidak ditemukan !";
        }
        $dosen = $res->data->data[0];
        return view("reg_dpl.data-diri", [
            "nama" => $dosen->nama,
            "nip" => $dosen->nip,
            "nidn" => $dosen->nidn,
            "alamat" => $dosen->alamat,
        ]);
    }

    public function register(Request $request)
    {
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

        $nim = session("token_api")->user->kode;
        $res = \IainApi::get("api/mahasiswa?kode=$nim");
        $mhs = $res->data->data[0];

        $n = new User();
        $n->username = session("token_api")->user->kode;
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

        return Redirect::to("mhs/reg/kpm");
    }
}
