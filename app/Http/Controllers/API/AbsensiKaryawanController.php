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

class AbsensiKaryawanController extends Controller
{

    /**
     * @OA\Get(
     *     path="/karyawan/absensi",
     *     tags={"AbsensiKaryawan"},
     *     operationId="GetAbsensi",
     *     summary="Ambil data absensi karyawan, dengan pencarian berdasarkan nama karyawan (wajib)",
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
     *         description="Berhasil mengambil data absensi karyawan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data absensi karyawan tersedia"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="John Doe"),
     *                     @OA\Property(property="nip", type="string", example="6535534"),
     *                     @OA\Property(property="tanggal", type="string", format="date", example="2025-06-01"),
     *                     @OA\Property(property="status", type="string", enum={"Hadir", "Izin", "Sakit", "Alpha"}, example="Hadir"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-02T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-02T11:00:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Post(
     *     path="/karyawan/absensi/create",
     *     tags={"AbsensiKaryawan"},
     *     operationId="CreateAbsensiKaryawan",
     *     summary="Tambah data absensi karyawan",
     *      security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_karyawan", "tanggal", "status"},
     *             @OA\Property(property="id_karyawan", type="integer", example=1, description="ID karyawan yang melakukan absensi"),
     *             @OA\Property(property="tanggal", type="string", format="date", example="2025-06-02", description="Tanggal absensi (format YYYY-MM-DD)"),
     *             @OA\Property(property="status", type="string", example="Hadir", description="Status absensi (Hadir, Izin, Sakit, Alpha)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Absensi karyawan berhasil ditambahkan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Absensi karyawan berhasil ditambahkan"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal atau absensi sudah ada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     *
     * @OA\Put(
     *     path="/karyawan/absensi/{id}/update",
     *     tags={"AbsensiKaryawan"},
     *     operationId="UpdateAbsensiById",
     *     summary="Update data absensi karyawan berdasarkan ID absensi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID absensi yang akan diupdate",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", example="Hadir", description="Status absensi (Hadir, Izin, Sakit, Alpha)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Absensi karyawan berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Absensi karyawan berhasil diupdate"),
     *             @OA\Property(property="data", type="object")
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
     *         description="Data absensi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data absensi tidak ditemukan")
     *         )
     *     )
     * )
     *
     * @OA\Delete(
     *     path="/karyawan/absensi/{id}/delete",
     *     tags={"AbsensiKaryawan"},
     *     operationId="DeleteAbsensiById",
     *     summary="Hapus data absensi karyawan berdasarkan ID absensi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID absensi yang akan dihapus",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data absensi berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data absensi berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data absensi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data absensi tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan saat menghapus data absensi",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Gagal menghapus data absensi: ...")
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

        // Cari absensi berdasarkan id_karyawan
        $absensiList = Absensi::where('id_karyawan', $karyawan->id)->get();

        if ($absensiList->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi karyawan tidak ditemukan',
                'data' => [],
            ], 404);
        }

        // Return data absensi dengan info karyawan
        return response()->json([
            'success' => true,
            'message' => 'Data absensi karyawan tersedia',
            'data' => $absensiList->map(function ($absensi) use ($karyawan) {
                return [
                    'id' => $absensi->id,
                    'nama' => $karyawan->nama,
                    'nip' => $karyawan->nip,
                    'tanggal' => $absensi->tanggal,
                    'status' => $absensi->status,
                    'created_at' => $absensi->created_at,
                    'updated_at' => $absensi->updated_at,
                ];
            }),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_karyawan' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ], [
            'id_karyawan.required' => 'ID karyawan wajib diisi.',
            'id_karyawan.exists' => 'ID karyawan tidak ditemukan di dalam data.',
            'tanggal.required' => 'Tanggal absensi wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'status.required' => 'Status absensi wajib diisi.',
            'status.in' => 'Status absensi harus salah satu dari: Hadir, Izin, Sakit, atau Alpha.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cek apakah sudah ada absensi untuk tanggal dan karyawan tersebut
        $exists = Absensi::where('id_karyawan', $request->id_karyawan)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Absensi untuk karyawan ini pada tanggal tersebut sudah ada.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $absensi = Absensi::create([
                'id_karyawan' => $request->id_karyawan,
                'tanggal' => $request->tanggal,
                'status' => $request->status,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Absensi karyawan berhasil ditambahkan',
                'data' => $absensi,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan data absensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ], [
            'status.required' => 'Status absensi wajib diisi.',
            'status.in' => 'Status absensi harus salah satu dari: Hadir, Izin, Sakit, atau Alpha.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $absensi = Absensi::find($id);
        if (!$absensi) {
            return response()->json([
                'message' => 'Data absensi tidak ditemukan.',
            ], 404);
        }

        DB::beginTransaction();
        try {
            $absensi->status = $request->status;
            $absensi->save();

            DB::commit();

            return response()->json([
                'message' => 'Status absensi berhasil diperbarui',
                'data' => $absensi,
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data absensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json(['message' => 'Data absensi tidak ditemukan'], 404);
        }

        DB::beginTransaction();

        try {
            $absensi->delete();

            DB::commit();
            return response()->json(['message' => 'Data absensi berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus data absensi: ' . $e->getMessage()], 500);
        }
    }
}
