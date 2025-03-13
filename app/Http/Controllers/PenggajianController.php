<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggajian;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajians = Penggajian::all();
        return response()->json($penggajians);
    }

    public function store(Request $request)
    {
        $penggajian = new Penggajian();
        $penggajian->nama_karyawan = $request->nama_karyawan;
        $penggajian->gaji_pokok = $request->gaji_pokok;
        $penggajian->tunjangan = $request->tunjangan;
        $penggajian->total_gaji = $request->gaji_pokok + $request->tunjangan;
        $penggajian->save();

        return response()->json($penggajian, 201);
    }

    public function show($id)
    {
        $penggajian = Penggajian::find($id);
        return response()->json($penggajian);
    }

    public function update(Request $request, $id)
    {
        $penggajian = Penggajian::find($id);
        $penggajian->nama_karyawan = $request->nama_karyawan;
        $penggajian->gaji_pokok = $request->gaji_pokok;
        $penggajian->tunjangan = $request->tunjangan;
        $penggajian->total_gaji = $request->gaji_pokok + $request->tunjangan;
        $penggajian->save();

        return response()->json($penggajian);
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::find($id);
        $penggajian->delete();

        return response()->json(null, 204);
    }
}
