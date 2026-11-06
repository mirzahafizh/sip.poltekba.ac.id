<?php

namespace App\Http\Controllers\UPA;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\RiwayatStatus;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LaporanController extends Controller
{
    /**
     * Dashboard UPA.
     */

public function index()
{
    $laporans = Laporan::with([
        'pelapor.unit',
        'gedung',
        'kategori',
        'penugasan.teknisi',
    ])
    ->whereIn('status', [
        'disetujui',
        'menunggu_penanganan_upa',
        'ditugaskan',
        'sedang_dikerjakan',
        'menunggu_verifikasi',
        'selesai',
    ])
    ->latest()
    ->paginate(10);

    $totalLaporanMasuk = Laporan::whereIn('status', [
        'disetujui',
        'menunggu_penanganan_upa',
        'ditugaskan',
        'sedang_dikerjakan',
        'menunggu_verifikasi',
        'selesai',
    ])->count();

    $totalMenungguPenugasan = Laporan::whereIn('status', [
        'disetujui',
        'menunggu_penanganan_upa',
    ])->count();

    $totalSedangDikerjakan = Laporan::where('status', 'sedang_dikerjakan')
        ->count();

    $totalMenungguVerifikasi = Laporan::where('status', 'menunggu_verifikasi')
        ->count();

    return view('upa.dashboard', compact(
        'laporans',
        'totalLaporanMasuk',
        'totalMenungguPenugasan',
        'totalSedangDikerjakan',
        'totalMenungguVerifikasi'
    ));
}


    /**
     * Daftar seluruh laporan yang menjadi tanggung jawab UPA.
     */
 
public function list(Request $request)
{
    $validated = $request->validate([
        'search' => ['nullable', 'string', 'max:100'],
        'status' => [
            'nullable',
            'in:disetujui,menunggu_penanganan_upa,ditugaskan,sedang_dikerjakan,menunggu_verifikasi,selesai'
        ],
    ]);

    $query = Laporan::with([
        'pelapor.unit',
        'gedung',
        'kategori',
        'penugasan.teknisi',
    ])
    ->whereIn('status', [
        'disetujui',
        'menunggu_penanganan_upa',
        'ditugaskan',
        'sedang_dikerjakan',
        'menunggu_verifikasi',
        'selesai',
    ]);

    // Pencarian
    if (!empty($validated['search'])) {
        $search = $validated['search'];

        $query->where(function ($q) use ($search) {
            $q->where('nomor_tiket', 'like', "%{$search}%")
                ->orWhere('judul_laporan', 'like', "%{$search}%")
                ->orWhereHas('pelapor', function ($pelapor) use ($search) {
                    $pelapor->where('name', 'like', "%{$search}%");
                });
        });
    }

    // Filter status
    if (!empty($validated['status'])) {
        $query->where('status', $validated['status']);
    }

    $laporans = $query
        ->latest()
        ->paginate(15)
        ->withQueryString();

    return view('upa.laporan.index', compact('laporans'));
}

    /**
     * Detail laporan.
     */
    public function show(Laporan $laporan)
    {
        $statusUPA = [
            'disetujui',
            'menunggu_penanganan_upa',
            'ditugaskan',
            'sedang_dikerjakan',
            'menunggu_verifikasi',
            'selesai',
        ];

        abort_unless(
            in_array($laporan->status, $statusUPA),
            404,
            'Laporan tidak ditemukan pada daftar penanganan UPA.'
        );

        $laporan->load([
            'pelapor.unit',
            'gedung',
            'kategori',
            'fotos',
            'penugasan.teknisi',
            'riwayat.pengguna',
            'verifikasi.verifikator',
        ]);

        $teknisis = User::where('role', 'teknisi')
            ->orderBy('name')
            ->get();

        return view('upa.laporan.show', compact(
            'laporan',
            'teknisis'
        ));
    }

    /**
     * Verifikasi hasil pekerjaan teknisi.
     */
    public function verify(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'hasil' => ['required', 'in:diterima,perlu_perbaikan'],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($laporan, $validated) {

            // Ambil ulang laporan dan kunci baris database.
            $laporanTerkunci = Laporan::whereKey($laporan->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan status masih menunggu verifikasi.
            abort_unless(
                $laporanTerkunci->status === 'menunggu_verifikasi',
                422,
                'Laporan belum menunggu verifikasi atau sudah diverifikasi.'
            );

            $oldStatus = $laporanTerkunci->status;

            // Tentukan status berikutnya.
            $newStatus = $validated['hasil'] === 'diterima'
                ? 'selesai'
                : 'sedang_dikerjakan';

            // Simpan data verifikasi.
            Verifikasi::create([
                'laporan_id' => $laporanTerkunci->id,
                'verifikator_id' => auth()->id(),
                'hasil' => $validated['hasil'],
                'catatan' => $validated['catatan'] ?? null,
                'diverifikasi_pada' => now(),
            ]);

            // Perbarui status laporan.
            $laporanTerkunci->update([
                'status' => $newStatus,
            ]);

            // Catat riwayat perubahan status.
            RiwayatStatus::create([
                'laporan_id' => $laporanTerkunci->id,
                'status_sebelumnya' => $oldStatus,
                'status_baru' => $newStatus,
                'user_id' => auth()->id(),
                'keterangan' => $validated['catatan']
                    ?: (
                        $newStatus === 'selesai'
                            ? 'Hasil perbaikan diterima dan laporan diselesaikan oleh UPA.'
                            : 'Hasil perbaikan memerlukan perbaikan ulang berdasarkan verifikasi UPA.'
                    ),
            ]);
        });

        return redirect()
            ->route('upa.laporan.show', $laporan)
            ->with(
                'success',
                $validated['hasil'] === 'diterima'
                    ? 'Hasil perbaikan diterima. Laporan berhasil diselesaikan.'
                    : 'Hasil perbaikan perlu diperbaiki kembali. Laporan dikembalikan kepada teknisi.'
            );
    }
}
