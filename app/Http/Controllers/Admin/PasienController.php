<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function dataPasien()
    {
        $dataPasien = Pasien::orderBy('nama')->get();
        return view('admin.pasien', compact('dataPasien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|numeric|digits:16',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'nama_pasangan' => 'nullable',
            'email' => 'required'
        ]);

        Pasien::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'nama_pasangan' => $request->nama_pasangan,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function pencarian(Request $request)
    {
        $query = Pasien::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%");
        }

        $dataPasien = $query->get();

        return view('admin.pasien', compact('dataPasien'));
    }
}
