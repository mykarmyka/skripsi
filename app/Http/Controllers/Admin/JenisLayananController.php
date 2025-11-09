<?php

namespace App\Http\Controllers\Admin;

use App\Models\JenisLayanan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class JenisLayananController extends Controller
{
    public function index()
    {
        $dataLayanan = JenisLayanan::orderBy('id')->get();
        return view('admin.jenis-layanan', compact('dataLayanan'));
    }

    public function storeLayanan(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'durasi' => 'required|integer|min:1',
        ]);

        JenisLayanan::create($request->only('nama_layanan', 'durasi'));

        return redirect()->route('admin.jenis-layanan')->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function destroyLayanan($id)
    {
        $layanan = JenisLayanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('admin.jenis-layanan')->with('success', 'Jenis layanan berhasil dihapus.');
    }



}
