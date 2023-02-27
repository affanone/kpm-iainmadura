<?php

namespace App\Http\Controllers\Dpl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dpl.dashboard');
    }

    public function show()
    {
        return view('dpl.mahasiswa');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = \App\IainApi::get('api/mahasiswa?limit=5000')->data->data;
            return DataTables::of($data)
                ->editColumn('prodi', function ($data) {
                    return $data->prodi->long . ' - ' . $data->prodi->fakultas->nama;
                })
                ->editColumn('tmp_lahir', function ($data) {
                    return $data->tmp_lahir . ', ' . $data->tgl_lahir;
                })
                ->editColumn('alamat', function ($data) {
                    return $data->alamat ?: '-';
                })
                ->make(true);
        }
    }
}
