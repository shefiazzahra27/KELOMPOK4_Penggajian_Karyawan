<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;


use App\Models\Karyawan;
use App\Models\Gaji;
use App\Models\Absensi;


class KaryawanController extends Controller
{

    /**
     * @OA\Get(
     *     path="/karyawan",
     *     tags={"Karyawan"},
     *     operationId="GetKaryawan",
     *     summary="Ambil data karyawan, dengan opsi pencarian berdasarkan nama",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Kata kunci pencarian nama karyawan (opsional)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data karyawan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data karyawan tersedia"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="John Doe"),
     *                     @OA\Property(property="nip", type="string", example="6535534"),
     *                     @OA\Property(property="jenis_kelamin", type="string", example="pria"),
     *                     @OA\Property(property="tanggal_lahir", type="string", format="date", example="2025-06-01"),
     *                     @OA\Property(property="alamat", type="string", example="Jl. Contoh No. 123"),
     *                     @OA\Property(property="jabatan", type="string", example="manager"),
     *                     @OA\Property(property="tunjangan", type="number", example=1500000),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-02T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-02T11:00:00Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Post(
     *     path="/karyawan/create",
     *     tags={"Karyawan"},
     *     operationId="CreateKaryawan",
     *     summary="Tambah data karyawan baru",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "nip", "jenis_kelamin", "tanggal_lahir", "jabatan", "tunjangan"},
     *             @OA\Property(property="nama", type="string", example="Budi Santoso"),
     *             @OA\Property(property="nip", type="string", example="1234567890"),
     *             @OA\Property(
     *                 property="jenis_kelamin",
     *                 type="string",
     *                 enum={"pria", "perempuan"},
     *                 example="pria"
     *             ),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date", example="1990-05-01"),
     *             @OA\Property(property="alamat", type="string", example="Jl. Melati No. 12"),
     *             @OA\Property(
     *                 property="jabatan",
     *                 type="string",
     *                 enum={"manager", "kepala divisi", "karyawan tetap", "karyawan kontrak", "office boy"},
     *                 example="manager"
     *             ),
     *             @OA\Property(property="tunjangan", type="integer", example=2000000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Karyawan berhasil ditambahkan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Karyawan berhasil ditambahkan")
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
     *  @OA\Put(
     *     path="/karyawan/update/{id}",
     *     tags={"Karyawan"},
     *     operationId="UpdateKaryawan",
     *     summary="Update data karyawan berdasarkan ID",
     *     description="Mengubah data karyawan berdasarkan ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID unik karyawan yang akan diperbarui",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data karyawan yang akan diperbarui",
     *         @OA\JsonContent(
     *             required={"nip", "nama", "jenis_kelamin", "tanggal_lahir", "jabatan", "tunjangan"},
     *             @OA\Property(property="nip", type="string", example="6535534"),
     *             @OA\Property(property="nama", type="string", example="John Doe"),
     *             @OA\Property(property="jenis_kelamin", type="string", enum={"pria", "perempuan"}, example="pria"),
     *             @OA\Property(property="tanggal_lahir", type="string", format="date", example="2025-06-01"),
     *             @OA\Property(property="alamat", type="string", example="Jl. Contoh No. 123"),
     *             @OA\Property(property="jabatan", type="string", example="manager"),
     *             @OA\Property(property="tunjangan", type="number", example=1500000)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Data Karyawan berhasil diperbarui",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data Karyawan berhasil diperbarui"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nip", type="string", example="123456"),
     *                 @OA\Property(property="nama", type="string", example="John Doe"),
     *                 @OA\Property(property="jenis_kelamin", type="string", example="pria"),
     *                 @OA\Property(property="tanggal_lahir", type="string", format="date", example="2025-06-01"),
     *                 @OA\Property(property="alamat", type="string", example="Jl. Contoh No. 123"),
     *                 @OA\Property(property="jabatan", type="string", example="manager"),
     *                 @OA\Property(property="tunjangan", type="number", example=1500000)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Karyawan tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Karyawan tidak ditemukan")
     *         )
     *     ),
     *
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
     * @OA\Delete(
     *     path="/karyawan/delete/{id}",
     *     tags={"Karyawan"},
     *     operationId="DeleteKaryawan",
     *     summary="Hapus karyawan berdasarkan ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID karyawan yang akan dihapus",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data Karyawan berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Data Karyawan berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Gagal menghapus data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Karyawan tidak ditemukan atau gagal menghapus data")
     *         )
     *     )
     * )
     */

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        $query = Karyawan::query();

        if ($searchTerm) {
            $query->where('nama', 'like', '%' . $searchTerm . '%');
        }

        $karyawans = $query->get();

        if ($karyawans->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data karyawan tersedia',
            'data' => $karyawans->map(function ($karyawan) {
                return [
                    'id' => $karyawan->id,
                    'nama' => $karyawan->nama,
                    'nip' => $karyawan->nip,
                    'jenis_kelamin' => $karyawan->jenis_kelamin,
                    'tanggal_lahir' => $karyawan->tanggal_lahir,
                    'alamat' => $karyawan->alamat,
                    'jabatan' => $karyawan->jabatan,
                    'tunjangan' => $karyawan->tunjangan,
                    'created_at' => $karyawan->created_at,
                    'updated_at' => $karyawan->updated_at,
                ];
            }),
        ]);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nip' => 'required|string|unique:karyawans,nip',
            'jenis_kelamin' => 'required|in:pria,perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'jabatan' => 'required|string|in:manager,kepala divisi,karyawan tetap,karyawan kontrak,office boy',
            'tunjangan' => 'required|numeric',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',

            'nip.required' => 'NIP wajib diisi.',
            'nip.string' => 'NIP harus berupa teks.',
            'nip.unique' => 'NIP sudah digunakan.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin hanya boleh "pria" atau "perempuan".',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',

            'alamat.string' => 'Alamat harus berupa teks.',

            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string' => 'Jabatan harus berupa teks.',
            'jabatan.in' => 'Jabatan harus salah satu dari: manager, kepala divisi, karyawan tetap, karyawan kontrak, office boy.',

            'tunjangan.required' => 'Tunjangan wajib diisi.',
            'tunjangan.numeric' => 'Tunjangan harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Buat data karyawan
            $karyawan = Karyawan::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'jabatan' => $request->jabatan,
                'tunjangan' => $request->tunjangan,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Karyawan berhasil ditambahkan'
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi dasar tanpa unique untuk nip
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nip' => 'required|string',
            'jenis_kelamin' => 'required|in:pria,perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'jabatan' => 'required|string|in:manager,kepala divisi,karyawan tetap,karyawan kontrak,office boy',
            'tunjangan' => 'required|numeric',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',

            'nip.required' => 'NIP wajib diisi.',
            'nip.string' => 'NIP harus berupa teks.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin hanya boleh "pria" atau "perempuan".',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',

            'alamat.string' => 'Alamat harus berupa teks.',

            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string' => 'Jabatan harus berupa teks.',
            'jabatan.in' => 'Jabatan harus salah satu dari: manager, kepala divisi, karyawan tetap, karyawan kontrak, office boy.',

            'tunjangan.required' => 'Tunjangan wajib diisi.',
            'tunjangan.numeric' => 'Tunjangan harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah nip sudah dipakai karyawan lain (bukan dirinya sendiri)
        $nipExists = Karyawan::where('nip', $request->nip)
            ->where('id', '!=', $id)  // exclude dirinya sendiri
            ->exists();

        if ($nipExists) {
            return response()->json([
                'errors' => ['nip' => ['NIP sudah digunakan oleh karyawan lain.']]
            ], 422);
        }

        // Jika validasi lolos, lanjut proses update
        DB::beginTransaction();

        try {
            $karyawan = Karyawan::findOrFail($id);
            $karyawan->nama = $request->nama;
            $karyawan->nip = $request->nip;
            $karyawan->jenis_kelamin = $request->jenis_kelamin;
            $karyawan->tanggal_lahir = $request->tanggal_lahir;
            $karyawan->alamat = $request->alamat;
            $karyawan->jabatan = $request->jabatan;
            $karyawan->tunjangan = $request->tunjangan;
            $karyawan->save();

            DB::commit();

            return response()->json([
                'message' => 'Data karyawan berhasil diperbarui',
                'data' => $karyawan
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        // Cek apakah data karyawan ada
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan tidak ditemukan atau gagal menghapus data'], 404);
        }

        DB::beginTransaction();

        try {
            // Hapus absensi jika ada
            if (Absensi::where('id_karyawan', $id)->exists()) {
                Absensi::where('id_karyawan', $id)->delete();
            }

            // Hapus gaji jika ada
            if (Gaji::where('id_karyawan', $id)->exists()) {
                Gaji::where('id_karyawan', $id)->delete();
            }

            // Hapus karyawan
            $karyawan->delete();

            DB::commit();
            return response()->json(['message' => 'Data Karyawan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
