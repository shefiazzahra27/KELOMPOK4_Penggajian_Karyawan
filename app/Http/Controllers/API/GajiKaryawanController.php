<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;


use App\Models\Karyawan;
use App\Models\Gaji;
use App\Models\Absensi;

class GajiKaryawanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/karyawan/gaji",
     *     tags={"GajiKaryawan"},
     *     operationId="GetGaji",
     *     summary="Ambil data gaji karyawan, dengan pencarian berdasarkan nama karyawan (wajib)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Kata kunci pencarian nama karyawan (wajib diisi)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data gaji karyawan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data gaji karyawan tersedia"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="John Doe"),
     *                     @OA\Property(property="nip", type="string", example="6535534"),
     *                     @OA\Property(property="periode", type="string", example="05/2025"),
     *                     @OA\Property(property="gaji_pokok", type="integer", example=5000000),
     *                     @OA\Property(property="potongan", type="integer", example=500000),
     *                     @OA\Property(property="total_gaji", type="integer", example=4500000),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-02T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-02T11:00:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Post(
     *     path="/karyawan/gaji/create",
     *     tags={"GajiKaryawan"},
     *     operationId="CreateGajiKaryawan",
     *     summary="Tambah data gaji karyawan baru",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_karyawan", "periode", "gaji_pokok", "potongan"},
     *             @OA\Property(property="id_karyawan", type="integer", example=1, description="ID karyawan yang menerima gaji"),
     *             @OA\Property(property="periode", type="string", example="05/2025", description="Periode gaji (Bulan/Tahun)"),
     *             @OA\Property(property="gaji_pokok", type="integer", example=5000000, description="Gaji pokok karyawan"),
     *             @OA\Property(property="potongan", type="integer", example=500000, description="Potongan gaji"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Gaji karyawan berhasil ditambahkan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Gaji karyawan berhasil ditambahkan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     *
     * @OA\Put(
     *     path="/karyawan/gaji/update/{id_karyawan}",
     *     tags={"GajiKaryawan"},
     *     operationId="UpdateGajiKaryawanByIdKaryawan",
     *     summary="Update data gaji karyawan berdasarkan ID karyawan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id_karyawan",
     *         in="path",
     *         description="ID karyawan yang gajinya akan diupdate",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"periode", "gaji_pokok", "potongan"},
     *             @OA\Property(property="periode", type="string", example="05/2025", description="Periode gaji (Bulan/Tahun)"),
     *             @OA\Property(property="gaji_pokok", type="integer", example=5000000, description="Gaji pokok karyawan"),
     *             @OA\Property(property="potongan", type="integer", example=500000, description="Potongan gaji")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Gaji karyawan berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Gaji karyawan berhasil diupdate")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data gaji tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data gaji tidak ditemukan")
     *         )
     *     )
     * )
     *
     *
     * @OA\Delete(
     *     path="/karyawan/gaji/delete/{id_karyawan}",
     *     tags={"GajiKaryawan"},
     *     operationId="DeleteGajiByKaryawanId",
     *     summary="Hapus data gaji karyawan berdasarkan ID karyawan",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id_karyawan",
     *         in="path",
     *         required=true,
     *         description="ID karyawan yang gajinya akan dihapus",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data gaji berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data gaji berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data gaji tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data gaji tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan saat menghapus data gaji",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Gagal menghapus data gaji: ...")
     *         )
     *     )
     * )
     */


    public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        if (!$searchTerm) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter search wajib diisi',
            ], 400);
        }

        // Cari karyawan berdasarkan nama dulu
        $karyawan = Karyawan::where('nama', 'like', '%' . $searchTerm . '%')->first();

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan',
                'data' => [],
            ], 404);
        }

        // Cari gaji berdasarkan id_karyawan
        $gajiList = Gaji::where('id_karyawan', $karyawan->id)->get();

        if ($gajiList->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data gaji karyawan tidak ditemukan',
                'data' => [],
            ], 404);
        }

        // Return data gaji dengan info karyawan
        return response()->json([
            'success' => true,
            'message' => 'Data gaji karyawan tersedia',
            'data' => $gajiList->map(function ($gaji) use ($karyawan) {
                return [
                    'id' => $gaji->id,
                    'nama' => $karyawan->nama,
                    'nip' => $karyawan->nip,
                    'periode' => $gaji->periode,
                    'gaji_pokok' => $gaji->gaji_pokok,
                    'potongan' => $gaji->potongan,
                    'total_gaji' => $gaji->total_gaji,
                    'created_at' => $gaji->created_at,
                    'updated_at' => $gaji->updated_at,
                ];
            }),
        ]);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_karyawan' => 'required|exists:karyawans,id',
            'periode' => 'required|string|regex:/^\d{2}\/\d{4}$/', // Format mm/yyyy
            'gaji_pokok' => 'required|integer|min:0',
            'potongan' => 'required|integer|min:0',
        ], [
            'id_karyawan.required' => 'ID karyawan wajib diisi.',
            'id_karyawan.exists' => 'Karyawan tidak ditemukan.',
            'periode.required' => 'Periode wajib diisi.',
            'periode.regex' => 'Format periode harus MM/YYYY.',
            'gaji_pokok.required' => 'Gaji pokok wajib diisi.',
            'gaji_pokok.integer' => 'Gaji pokok harus berupa angka.',
            'potongan.required' => 'Potongan wajib diisi.',
            'potongan.integer' => 'Potongan harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah sudah ada data gaji untuk karyawan tersebut
        $exists = Gaji::where('id_karyawan', $request->id_karyawan)->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Data gaji untuk karyawan tersebut sudah ada.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Hitung total gaji otomatis
            $total_gaji = $request->gaji_pokok - $request->potongan;
            if ($total_gaji < 0) {
                $total_gaji = 0; // Supaya gak negatif
            }

            $gaji = Gaji::create([
                'id_karyawan' => $request->id_karyawan,
                'periode' => $request->periode,
                'gaji_pokok' => $request->gaji_pokok,
                'potongan' => $request->potongan,
                'total_gaji' => $total_gaji,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data gaji karyawan berhasil ditambahkan',
                'data' => $gaji,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan data gaji',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, $id_karyawan)
    {
        $validator = Validator::make($request->all(), [
            'periode' => 'required|string|regex:/^\d{2}\/\d{4}$/', // Format mm/yyyy
            'gaji_pokok' => 'required|integer|min:0',
            'potongan' => 'required|integer|min:0',
        ], [
            'periode.required' => 'Periode wajib diisi.',
            'periode.regex' => 'Format periode harus MM/YYYY.',
            'gaji_pokok.required' => 'Gaji pokok wajib diisi.',
            'gaji_pokok.integer' => 'Gaji pokok harus berupa angka.',
            'potongan.required' => 'Potongan wajib diisi.',
            'potongan.integer' => 'Potongan harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $gaji = Gaji::where('id_karyawan', $id_karyawan)->first();

        if (!$gaji) {
            return response()->json([
                'message' => 'Data gaji tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $total_gaji = $request->gaji_pokok - $request->potongan;
            if ($total_gaji < 0) {
                $total_gaji = 0;
            }

            $gaji->update([
                'periode' => $request->periode,
                'gaji_pokok' => $request->gaji_pokok,
                'potongan' => $request->potongan,
                'total_gaji' => $total_gaji,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Data gaji karyawan berhasil diupdate',
                'data' => $gaji,
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate data gaji',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id_karyawan)
    {
        $gaji = Gaji::where('id_karyawan', $id_karyawan)->first();

        if (!$gaji) {
            return response()->json(['message' => 'Data gaji tidak ditemukan'], 404);
        }

        DB::beginTransaction();

        try {
            $gaji->delete();

            DB::commit();
            return response()->json(['message' => 'Data gaji berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus data gaji: ' . $e->getMessage()], 500);
        }
    }
}
