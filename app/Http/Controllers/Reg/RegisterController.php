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
use App\Models\Pendaftaran;
use App\Models\DokumenPendaftaran;
use App\Models\Kpm;

class RegisterController extends Controller
{
    function update_profil(Request $request)
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

        $nim = Auth::user()->username;
        $m = Mahasiswa::where("nim", $nim)->first();
        $m->hp = $request->hp;
        $m->alamat = $request->alamat;
        $m->save();
        return Redirect::to("reg/kpm");
    }

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
        $nim = Auth::user()->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::where("status", 1)->first();
        return view("register.data-diri", [
            "step" => 1,
            "mhs" => $mhs,
            "hp" => $mhs->hp,
            "alamat" => $mhs->alamat,
            "nama_kpm" =>
                "KPM IAIN Madura Semester $ta->semester $ta->tahun/" .
                ($ta->tahun + 1),
        ]);
    }

    public function kpm()
    {
        $nim = Auth::user()->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::where("status", 1)->first();

        if (!$mhs) {
            return Redirect::to("reg/profil")
                ->withErrors("Silahkan isikan data diri anda", "daftar")
                ->withInput();
        }

        $pend = Pendaftaran::where("mahasiswa_id", $mhs->id)
            ->whereRaw(
                "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
            )
            ->first();

        return view("register.jenis-kpm", [
            "step" => 2,
            "data" => $mhs,
            "kpm" => $ta->kpm,
            "jeniskpm" => $pend->subkpm_id ?? "",
            "nama_kpm" =>
                "KPM IAIN Madura Semester $ta->semester $ta->tahun/" .
                ($ta->tahun + 1),
        ]);
    }

    public function update_kpm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "jeniskpm" => "required",
            ],
            [
                "jeniskpm.required" => "Jenis KPM harus dipilih",
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nim = Auth::user()->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::where("status", 1)->first();
        Pendaftaran::where("mahasiswa_id", $mhs->id)
            ->whereRaw(
                "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
            )
            ->delete();
        $pend = new Pendaftaran();
        $pend->mahasiswa_id = $mhs->id;
        $pend->subkpm_id = $request->jeniskpm;
        $pend->save();
        return Redirect::to("reg/syarat");
    }

    public function syarat(Request $request)
    {
        $nim = Auth::user()->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::with("kpm.subkpm")
            ->where("status", 1)
            ->first();
        $pend = Pendaftaran::with("subkpm.kpm")
            ->where("mahasiswa_id", $mhs->id)
            ->whereRaw(
                "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
            )
            ->first();
        if (!$pend) {
            $validator = Validator::make([], []);
            $validator->errors()->add("jeniskpm", "Jenis KPM harus dipilih");
            return Redirect::to("reg/kpm")
                ->withErrors($validator)
                ->withInput();
        }
        return view("register.syarat-kpm", [
            "step" => 3,
            "data" => $mhs,
            "pendaftaran" => $pend,
            "nama_kpm" =>
                "KPM IAIN Madura Semester $ta->semester $ta->tahun/" .
                ($ta->tahun + 1),
        ]);
    }

    public function upload_syarat(Request $request)
    {
        $nim = Auth::user()->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::with("kpm.subkpm")
            ->where("status", 1)
            ->first();
        $pend = Pendaftaran::with("subkpm.kpm")
            ->where("mahasiswa_id", $mhs->id)
            ->whereRaw(
                "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
            )
            ->first();
        $rules = [];
        foreach ($pend->subkpm->config_upload as $key => $conf) {
            $rules[$conf->name] = $conf->validator;
        }
        foreach ($pend->subkpm->kpm->config_upload as $key => $conf) {
            $rules[$conf->name] = $conf->validator;
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        foreach ($pend->subkpm->config_upload as $key => $conf) {
            if ($request->hasFile($conf->name)) {
                $file = \Helper::upload(
                    $request->file($conf->name),
                    "doc_pendaftaran",
                    true
                );
            }
            $rules[$conf->name] = $conf->validator;
        }
        foreach ($pend->subkpm->kpm->config_upload as $key => $conf) {
            $rules[$conf->name] = $conf->validator;
        }
        if ($request->hasFile("file")) {
            // do something with uploaded file
        }

        return "lewat";
    }
}
