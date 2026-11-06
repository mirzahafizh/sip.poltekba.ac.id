<?php

namespace App\Http\Controllers\UPA;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Penugasan;
use App\Models\RiwayatStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenugasanController extends Controller
{
    /**
     * Menugaskan laporan kepada teknisi.
     */
    public function store(Request $request, Laporan $laporan)
    {
        // Validasi input.
        $validated = $request->validate([
            'teknisi_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'catatan_tugas' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        // Pastikan akun yang dipilih benar-benar teknisi.
        $teknisi = User::whereKey($validated['teknisi_id'])
            ->where('role', 'teknisi')
            ->first();

        if (! $teknisi) {
            throw ValidationException::withMessages([
                'teknisi_id' => 'Akun yang dipilih bukan akun teknisi.',
            ]);
        }

        DB::transaction(function () use ($laporan, $validated) {

            // Kunci laporan selama proses penugasan.
            $laporanTerkunci = Laporan::whereKey($laporan->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Penugasan hanya boleh dilakukan jika laporan sudah disetujui.
            if (! in_array($laporanTerkunci->status, [
                'disetujui',
                'menunggu_penanganan_upa',
            ], true)) {
                throw ValidationException::withMessages([
                    'teknisi_id' => 'Laporan ini sudah ditugaskan atau tidak dapat ditugaskan kembali.',
                ]);
            }

            // Pastikan teknisi masih memiliki role teknisi.
            $teknisi = User::whereKey($validated['teknisi_id'])
                ->where('role', 'teknisi')
                ->first();

            if (! $teknisi) {
                throw ValidationException::withMessages([
                    'teknisi_id' => 'Akun teknisi tidak ditemukan atau sudah tidak aktif sebagai teknisi.',
                ]);
            }

            $oldStatus = $laporanTerkunci->status;

            // Simpan data penugasan.
            Penugasan::create([
                'laporan_id' => $laporanTerkunci->id,
                'teknisi_id' => $teknisi->id,
                'ditugaskan_oleh' => auth()->id(),
                'catatan_tugas' => $validated['catatan_tugas'] ?? null,
                'tanggal_penugasan' => now(),
            ]);

            // Ubah status laporan.
            $laporanTerkunci->update([
                'status' => 'ditugaskan',
            ]);

            // Catat riwayat perubahan status.
            RiwayatStatus::create([
                'laporan_id' => $laporanTerkunci->id,
                'status_sebelumnya' => $oldStatus,
                'status_baru' => 'ditugaskan',
                'user_id' => auth()->id(),
                'keterangan' => 'Laporan ditugaskan kepada teknisi: '
                    . $teknisi->name
                    . (
                        ! empty($validated['catatan_tugas'])
                            ? '. Instruksi: ' . $validated['catatan_tugas']
                            : '.'
                    ),
            ]);
        });

        return redirect()
            ->route('upa.laporan.show', $laporan)
            ->with('success', 'Teknisi berhasil ditugaskan dan laporan masuk ke daftar pekerjaan teknisi.');
    }
}
