<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\KategoriKerusakan;
use App\Models\Laporan;
use App\Models\LaporanFoto;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class LaporanController extends Controller
{
    /**
     * Dashboard pelapor dan daftar laporan miliknya.
     */
    public function index()
    {
        $userId = auth()->id();

        $laporans = Laporan::with(['gedung', 'kategori'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        $statistik = Laporan::where('user_id', $userId)
            ->selectRaw('COUNT(*) as total_laporan')
            ->selectRaw("
                SUM(CASE WHEN status = 'menunggu_persetujuan_wadir_ii'
                    THEN 1 ELSE 0 END) as menunggu_persetujuan
            ")
            ->selectRaw("
                SUM(CASE WHEN status IN (
                    'menunggu_penanganan_upa',
                    'ditugaskan',
                    'sedang_dikerjakan',
                    'menunggu_verifikasi'
                ) THEN 1 ELSE 0 END) as sedang_ditangani
            ")
            ->selectRaw("
                SUM(CASE WHEN status = 'selesai'
                    THEN 1 ELSE 0 END) as selesai
            ")
            ->first();

        $totalLaporan = $statistik->total_laporan ?? 0;
        $menungguPersetujuan = $statistik->menunggu_persetujuan ?? 0;
        $sedangDitangani = $statistik->sedang_ditangani ?? 0;
        $selesai = $statistik->selesai ?? 0;

        return view('pelapor.dashboard', compact(
            'laporans',
            'totalLaporan',
            'menungguPersetujuan',
            'sedangDitangani',
            'selesai'
        ));
    }

    /**
     * Menampilkan formulir pembuatan laporan.
     */
    public function create()
    {
        $gedungs = Gedung::where('aktif', true)
            ->orderBy('nama_gedung')
            ->get();

        $kategoris = KategoriKerusakan::where('aktif', true)
            ->orderBy('nama_kategori')
            ->get();

        return view('pelapor.laporan.create', compact(
            'gedungs',
            'kategoris'
        ));
    }

    /**
     * Menyimpan laporan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gedung_id' => [
                'required',
                'exists:gedungs,id',
            ],

            'kategori_kerusakan_id' => [
                'required',
                'exists:kategori_kerusakans,id',
            ],

            'lokasi_detail' => [
                'required',
                'string',
                'max:255',
            ],

            'judul_laporan' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'required',
                'string',
                'max:10000',
            ],

            'foto' => [
                'nullable',
                'array',
                'max:5',
            ],

            'foto.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'gedung_id.required' => 'Silakan pilih gedung.',
            'gedung_id.exists' => 'Gedung yang dipilih tidak valid.',

            'kategori_kerusakan_id.required' => 'Silakan pilih kategori kerusakan.',
            'kategori_kerusakan_id.exists' => 'Kategori kerusakan tidak valid.',

            'lokasi_detail.required' => 'Lokasi detail wajib diisi.',
            'judul_laporan.required' => 'Judul laporan wajib diisi.',
            'deskripsi.required' => 'Deskripsi kerusakan wajib diisi.',

            'foto.max' => 'Maksimal 5 foto yang dapat diunggah.',
            'foto.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
        ]);

        $uploadedFiles = [];

        try {
            $laporan = DB::transaction(function () use (
                $validated,
                $request,
                &$uploadedFiles
            ) {
                // Membuat laporan.
                $laporan = Laporan::create([
                    'nomor_tiket' => $this->generateNomorTiket(),
                    'user_id' => auth()->id(),
                    'gedung_id' => $validated['gedung_id'],
                    'kategori_kerusakan_id' => $validated['kategori_kerusakan_id'],
                    'lokasi_detail' => $validated['lokasi_detail'],
                    'judul_laporan' => $validated['judul_laporan'],
                    'deskripsi' => $validated['deskripsi'],
                    'status' => 'menunggu_persetujuan_wadir_ii',
                ]);

                // Mencatat riwayat status pertama.
                RiwayatStatus::create([
                    'laporan_id' => $laporan->id,
                    'status_sebelumnya' => null,
                    'status_baru' => 'menunggu_persetujuan_wadir_ii',
                    'user_id' => auth()->id(),
                    'keterangan' => 'Laporan dibuat dan menunggu persetujuan Wakil Direktur II.',
                ]);

                // Mengunggah foto kerusakan.
                foreach ($request->file('foto', []) as $file) {
                    $path = $file->store('laporan', 'public');

                    if (!$path) {
                        throw new \RuntimeException(
                            'Gagal mengunggah foto laporan.'
                        );
                    }

                    $uploadedFiles[] = $path;

                    LaporanFoto::create([
                        'laporan_id' => $laporan->id,
                        'jenis_foto' => 'kerusakan',
                        'nama_file' => $file->getClientOriginalName(),
                        'path' => $path,
                        'uploaded_by' => auth()->id(),
                    ]);
                }

                return $laporan;
            });

        } catch (Throwable $exception) {
            // Menghapus file jika transaksi gagal.
            if (!empty($uploadedFiles)) {
                Storage::disk('public')->delete($uploadedFiles);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Laporan gagal disimpan. Silakan coba kembali.');
        }

        return redirect()
            ->route('pelapor.laporan.show', $laporan)
            ->with(
                'success',
                'Laporan berhasil dikirim. Nomor tiket: '.$laporan->nomor_tiket
            );
    }

    /**
     * Menampilkan detail laporan milik pelapor.
     */
    public function show(Laporan $laporan)
    {
        // Memastikan laporan hanya dapat dilihat pemiliknya.
        abort_unless(
            $laporan->user_id === auth()->id(),
            403,
            'Kamu tidak memiliki akses ke laporan ini.'
        );

        // Memuat relasi yang diperlukan halaman detail.
        $laporan->load([
            'pelapor.unit',
            'gedung',
            'kategori',
            'fotos',
            'riwayat.pengguna',
            'penugasan.teknisi',
            'verifikasi.verifikator',
        ]);

        return view('pelapor.laporan.show', compact('laporan'));
    }

    /**
     * Membuat nomor tiket unik.
     *
     * Contoh: UPA-20261106-ABC123
     */
    private function generateNomorTiket(): string
    {
        do {
            $nomor = 'UPA-'.now()->format('Ymd').'-'.Str::upper(
                Str::random(6)
            );

        } while (
            Laporan::where('nomor_tiket', $nomor)->exists()
        );

        return $nomor;
    }
}
