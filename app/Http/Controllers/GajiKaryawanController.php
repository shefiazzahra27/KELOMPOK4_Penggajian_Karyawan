<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="GajiKaryawan",
 *     description="API untuk data gaji karyawan"
 * )
 */
class GajiKaryawanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/gaji-karyawan",
     *     summary="Ambil semua data gaji karyawan",
     *     tags={"GajiKaryawan"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="periode", type="string"),
     *             @OA\Property(property="gaji_pokok", type="number"),
     *             @OA\Property(property="potongan", type="number"),
     *             @OA\Property(property="total_gaji", type="number"),
     *             @OA\Property(property="karyawan", type="object",
     *                 @OA\Property(property="nama", type="string"),
     *                 @OA\Property(property="nip", type="string"),
     *                 @OA\Property(property="jabatan", type="array", @OA\Items(
     *                     @OA\Property(property="nama_jabatan", type="string"),
     *                     @OA\Property(property="tunjangan", type="number")
     *                 ))
     *             )
     *         ))
     *     )
     * )
     */
    public function index()
    {
        $gaji = Gaji::with(['karyawan.jabatan'])->get();

        return response()->json($gaji);
    }
}

