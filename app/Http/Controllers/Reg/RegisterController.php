<?php

namespace App\Http\Controllers\Reg;

use App\Http\Controllers\Controller;
use App\Models\DokumenPendaftaran;
use App\Models\Kpm;
use App\Models\Mahasiswa;
use App\Models\Pendaftaran;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function update_profil(Request $request)
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
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::where("status", 1)->first();
        // $pend = Pendaftaran::with("subkpm.kpm")
        //     ->where("mahasiswa_id", $mhs->id)
        //     ->whereRaw(
        //         "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
        //     )
        //     ->first();
        if (!in_array(session("status"), [0, 2])) {
            return Redirect::to("mhs/reg/profil");
        }
        $m->hp = $request->hp;
        $m->alamat = $request->alamat;
        $m->save();
        return Redirect::to("mhs/reg/kpm");
    }

    public function registrasi(Request $request)
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
        session()->push("user", Auth::user());
        session()->push("register", true);
        \Log::set("Melakukan pendaftaran", "register");

        return Redirect::to(route('mhs.reg.kpm.get'));
    }

    public function profil()
    {
        $nim = Auth::user()->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::where("status", 1)->first();
        $pend = Pendaftaran::with("subkpm.kpm")
            ->where("mahasiswa_id", $mhs->id)
            ->whereRaw(
                "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
            )
            ->first();
        return view("register.data-diri", [
            "step" => 1,
            "mhs" => $mhs,
            "hp" => $mhs->hp,
            "alamat" => $mhs->alamat,
            "pendaftaran" => $pend,
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
            return Redirect::to("mhs/reg/profil")
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
            "mhs" => $mhs,
            "kpm" => $ta->kpm,
            "pendaftaran" => $pend,
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
        $pend = Pendaftaran::with("subkpm.kpm")
            ->where("mahasiswa_id", $mhs->id)
            ->whereRaw(
                "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
            )
            ->first();
        if (!in_array(session("status"), [0, 2])) {
            return Redirect::to("mhs/reg/kpm");
        }
        if ($pend) {
            if ($pend->subkpm_id != $request->jeniskpm) {
                // update data
                $file = DokumenPendaftaran::where(
                    "pendaftaran_id",
                    $pend->id
                )->get();
                foreach ($file as $key => $value) {
                    \Helper::delete_file($value->path);
                }
                DokumenPendaftaran::where(
                    "pendaftaran_id",
                    $pend->id
                )->delete();
                $pend->subkpm_id = $request->jeniskpm;
                $pend->save();
            }
        } else {
            $pend = new Pendaftaran();
            $pend->mahasiswa_id = $mhs->id;
            $pend->subkpm_id = $request->jeniskpm;
            $pend->save();
        }
        return Redirect::to("mhs/reg/syarat");
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
        $doc = DokumenPendaftaran::where("pendaftaran_id", $pend->id)->get();

        if (!$pend) {
            $validator = Validator::make([], []);
            $validator->errors()->add("jeniskpm", "Jenis KPM harus dipilih");
            return Redirect::to("mhs/reg/kpm")
                ->withErrors($validator)
                ->withInput();
        }
        return view("register.syarat-kpm", [
            "step" => 3,
            "mhs" => $mhs,
            "document" => $doc,
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
        if (!in_array(session("status"), [0, 2])) {
            return Redirect::to("mhs/reg/syarat");
        }

        $documents = DokumenPendaftaran::where(
            "pendaftaran_id",
            $pend->id
        )->get();

        $rules = [];
        $message_error = [];
        foreach ($pend->subkpm->config->upload as $key => $conf) {
            $f = collect($documents)->first(function ($d) use ($conf) {
                return $d ? $d->desc->name == $conf->name : false;
            });
            if (!$f) {
                $rule = [];
                foreach ($conf->validator as $kv => $vv) {
                    array_push($rule, $vv->rule);
                    $message_error[$conf->name . "." . $vv->rule] =
                    $vv->message;
                }
                $rules[$conf->name] = join("|", $rule);
            }
        }
        foreach ($pend->subkpm->kpm->config->upload as $key => $conf) {
            $f = collect($documents)->first(function ($d) use ($conf) {
                return $d ? $d->desc->name == $conf->name : false;
            });
            if (!$f) {
                $rule = [];
                foreach ($conf->validator as $kv => $vv) {
                    array_push($rule, $vv->rule);
                    $message_error[$conf->name . "." . $vv->rule] =
                    $vv->message;
                }
                $rules[$conf->name] = join("|", $rule);
            }
        }
        $validator = Validator::make($request->all(), $rules, $message_error);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        foreach ($pend->subkpm->config->upload as $key => $conf) {
            if ($request->hasFile($conf->name)) {
                $file = \Helper::upload(
                    $request->file($conf->name),
                    "doc_pendaftaran",
                    true
                );
                $f = collect($documents)->first(function ($d) use ($conf) {
                    return $d ? $d->desc->name == $conf->name : false;
                });
                if ($f) {
                    \Helper::delete_file($f->path);
                    $doc = DokumenPendaftaran::find($f->id);
                } else {
                    $doc = new DokumenPendaftaran();
                }
                $doc->pendaftaran_id = $pend->id;
                $doc->name = $file->name;
                $doc->url = $file->url;
                $doc->md5 = $file->md5;
                $doc->size = $file->size;
                $doc->extension = $file->extension;
                $doc->desc = json_encode([
                    "name" => $conf->name,
                ]);
                $doc->save();
            }
        }
        foreach ($pend->subkpm->kpm->config->upload as $key => $conf) {
            if ($request->hasFile($conf->name)) {
                $file = \Helper::upload(
                    $request->file($conf->name),
                    "doc_pendaftaran",
                    true
                );
                $f = collect($documents)->first(function ($d) use ($conf) {
                    return $d ? $d->desc->name == $conf->name : false;
                });
                if ($f) {
                    \Helper::delete_file($f->path);
                    $doc = DokumenPendaftaran::find($f->id);
                } else {
                    $doc = new DokumenPendaftaran();
                }
                $doc->pendaftaran_id = $pend->id;
                $doc->name = $file->name;
                $doc->url = $file->url;
                $doc->md5 = $file->md5;
                $doc->size = $file->size;
                $doc->extension = $file->extension;
                $doc->desc = json_encode([
                    "name" => $conf->name,
                ]);
                $doc->save();
            }
        }
        return Redirect::to("mhs/reg/final");
    }

    public function finalisasi()
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

        $tup =
        count($pend->subkpm->kpm->config->upload) +
        count($pend->subkpm->config->upload);
        if ($tup > 0) {
            $doc = DokumenPendaftaran::where(
                "pendaftaran_id",
                $pend->id
            )->get();
            if (!count($doc)) {
                return redirect()
                    ->to("mhs/reg/syarat")
                    ->withErrors(
                        "Silahkan upload berkas yang diminta !!",
                        "daftar"
                    );
            }
        }

        $doc = DokumenPendaftaran::where("pendaftaran_id", $pend->id)->get();
        return view("register.finalisasi", [
            "step" => 4,
            "mhs" => $mhs,
            "document" => $doc,
            "pendaftaran" => $pend,
            "nama_kpm" =>
            "KPM IAIN Madura Semester $ta->semester $ta->tahun/" .
            ($ta->tahun + 1),
        ]);
    }

    public function verifikasi_dan_finalisasi(Request $request)
    {
        $nim = Auth::user()->username;
        $mhs = Mahasiswa::where("nim", $nim)->first();
        $ta = TahunAkademik::with("kpm.subkpm")
            ->where("status", 1)
            ->first();
        $pendaftaran = Pendaftaran::with("subkpm.kpm")
            ->where("mahasiswa_id", $mhs->id)
            ->whereRaw(
                "exists(select * from subkpms where subkpms.id = pendaftarans.subkpm_id and exists(select * from kpms where kpms.id = subkpms.kpm_id and kpms.tahun_akademik_id = '$ta->id'))"
            )
            ->first();
        $document = DokumenPendaftaran::where(
            "pendaftaran_id",
            $pendaftaran->id
        )->get();

        $message = "";
        if (!$request->has("hp")) {
            $message = "Nomor hp belum anda centang !!";
        } elseif (!$request->has("alamat")) {
            $message = "Alamat belum anda centang !!";
        } else {
            foreach (
                $pendaftaran->subkpm->kpm->config->upload as $key => $config
            ) {
                $a = collect($document)->first(function ($i) use ($config) {
                    return $i ? $i->desc->name == $config->name : false;
                });
                if ($a) {
                    if (!$request->has($config->name)) {
                        $message = $config->label . " belum anda centang !!";
                    }
                }
            }

            foreach ($pendaftaran->subkpm->config->upload as $key => $config) {
                $a = collect($document)->first(function ($i) use ($config) {
                    return $i ? $i->desc->name == $config->name : false;
                });
                if ($a) {
                    if (!$request->has($config->name)) {
                        $message = $config->label . " belum anda centang !!";
                    }
                }
            }
        }
        if ($message) {
            return redirect()
                ->back()
                ->withErrors($message, "final")
                ->withInput();
        } else {
            if (!in_array(session("status"), [0, 2])) {
                return Redirect::to("mhs/reg/final");
            }
            $status = $pendaftaran->subkpm->config->validate ? 1 : 3;
            $pendaftaran->status = $status;
            $pendaftaran->save();
            session()->put("status", $status);
            return Redirect::to("mhs/reg/final");
        }
    }

    // percobaan
    public function dummy_mahasiswa()
    {
        return 'off';
        $mhs = \IainApi::get("api/mahasiswa?page=1&limit=100&fak=1");
        foreach ($mhs->data->data as $key => $value) {
            $mhs = $value;
            $n = User::where('username', $value->kode)->first();
            if (!$n) {
                $n = new User();
                $n->username = $value->kode;
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
                $m->hp = 'TES DATA DUMMI';
                $m->alamat = 'TES DATA DUMMI';
                $m->save();

                $pend = new Pendaftaran();
                $pend->mahasiswa_id = $m->id;
                $pend->subkpm_id = '7b1b77f2-145e-40dd-835f-ad2ec85a0323';
                $pend->save();
            }
        }
        return 'done';
    }
}
