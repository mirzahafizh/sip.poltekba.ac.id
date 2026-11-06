<?php

namespace App\Http\Controllers\Wadir;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PersetujuanController extends Controller
{
    /**
     * Daftar status laporan yang tersedia.
     */
    private const STATUSES = [
        'laporan_baru',
        'menunggu_persetujuan_wadir_ii',
        'ditolak',
        'disetujui',
        'menunggu_penanganan_upa',
        'ditugaskan',
        'sedang_dikerjakan',
        'menunggu_verifikasi',
        'selesai',
    ];

    /**
     * Dashboard Wadir II.
     * Menampilkan laporan yang menunggu persetujuan.
     */
    public function index()
    {
        // Laporan yang perlu diperiksa Wadir II.
        $laporans = Laporan::with([
                'pelapor.unit',
                'gedung',
                'kategori',
            ])
            ->where('status', 'menunggu_persetujuan_wadir_ii')
            ->latest()
            ->paginate(15);

        // Statistik laporan.
        $totalMenunggu = Laporan::where(
            'status',
            'menunggu_persetujuan_wadir_ii'
        )->count();

        // Laporan yang sudah disetujui dan diteruskan ke proses UPA.
        $totalDisetujui = Laporan::whereIn('status', [
            'disetujui',
            'menunggu_penanganan_upa',
            'ditugaskan',
            'sedang_dikerjakan',
            'menunggu_verifikasi',
            'selesai',
        ])->count();

        $totalDitolak = Laporan::where('status', 'ditolak')->count();

        return view('wadir.dashboard', compact(
            'laporans',
            'totalMenunggu',
            'totalDisetujui',
            'totalDitolak'
        ));
    }

    /**
     * Menampilkan seluruh laporan.
     * Mendukung pencarian, filter status, dan pagination.
     */
    public function list(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(self::STATUSES)],
        ]);

        $query = Laporan::with([
            'pelapor.unit',
            'gedung',
            'kategori',
        ]);

        // Pencarian berdasarkan nomor tiket, judul, dan pelapor.
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%{$search}%")
                    ->orWhere('judul_laporan', 'like', "%{$search}%")
                    ->orWhereHas('pelapor', function ($pelapor) use ($search) {
                        $pelapor->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan status.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporans = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('wadir.laporan.index', compact('laporans'));
    }

    /**
     * Menampilkan detail laporan.
     */
    public function show(Laporan $laporan)
    {
        $laporan->load([
            'pelapor.unit',
            'gedung',
            'kategori',
            'fotos',
            'riwayat.pengguna',
        ]);

        return view('wadir.laporan.show', compact('laporan'));
    }

    /**
     * Menyetujui laporan.
     */
    public function approve(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'keterangan' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($laporan, $validated) {

            // Kunci data agar tidak diproses bersamaan.
            $dataLaporan = Laporan::whereKey($laporan->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan status masih menunggu persetujuan.
            abort_unless(
                $dataLaporan->status === 'menunggu_persetujuan_wadir_ii',
                422,
                'Laporan tidak sedang menunggu persetujuan.'
            );

            $oldStatus = $dataLaporan->status;

            // Perbarui status laporan.
            $dataLaporan->update([
                'status' => 'disetujui',
                'disetujui_oleh' => auth()->id(),
                'disetujui_pada' => now(),
                'catatan_penolakan' => null,
            ]);

            // Simpan riwayat perubahan status.
            RiwayatStatus::create([
                'laporan_id' => $dataLaporan->id,
                'status_sebelumnya' => $oldStatus,
                'status_baru' => 'disetujui',
                'user_id' => auth()->id(),
                'keterangan' => $validated['keterangan']
                    ?? 'Laporan disetujui oleh Wakil Direktur II.',
            ]);
        });

        return redirect()
            ->route('wadir.laporan.show', $laporan)
            ->with('success', 'Laporan berhasil disetujui dan diteruskan ke UPA.');
    }

    /**
     * Menolak laporan.
     */
    public function reject(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'catatan_penolakan' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use ($laporan, $validated) {

            // Kunci data agar tidak diproses bersamaan.
            $dataLaporan = Laporan::whereKey($laporan->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan status masih menunggu persetujuan.
            abort_unless(
                $dataLaporan->status === 'menunggu_persetujuan_wadir_ii',
                422,
                'Laporan tidak sedang menunggu persetujuan.'
            );

            $oldStatus = $dataLaporan->status;

            // Perbarui status laporan.
            $dataLaporan->update([
                'status' => 'ditolak',
                'disetujui_oleh' => auth()->id(),
                'disetujui_pada' => now(),
                'catatan_penolakan' => $validated['catatan_penolakan'],
            ]);

            // Simpan riwayat perubahan status.
            RiwayatStatus::create([
                'laporan_id' => $dataLaporan->id,
                'status_sebelumnya' => $oldStatus,
                'status_baru' => 'ditolak',
                'user_id' => auth()->id(),
                'keterangan' => $validated['catatan_penolakan'],
            ]);
        });

        return redirect()
            ->route('wadir.laporan.show', $laporan)
            ->with('success', 'Laporan berhasil ditolak.');
    }
}
