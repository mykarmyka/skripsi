<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'stok_tersedia' => 'required|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'jenis' => $request->jenis,
            'stok_tersedia' => $request->stok_tersedia,
        ]);

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil ditambahkan!');
    }
}
