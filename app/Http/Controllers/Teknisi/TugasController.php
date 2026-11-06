<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LaporanFoto;
use App\Models\Penugasan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TugasController extends Controller
{
    /**
     * Dashboard teknisi.
     * Menampilkan pekerjaan yang ditugaskan kepada teknisi yang login.
     */
    public function index()
    {
        $teknisiId = auth()->id();

        $penugasans = Penugasan::with([
            'laporan.gedung',
            'laporan.kategori',
            'laporan.pelapor',
        ])
            ->where('teknisi_id', $teknisiId)
            ->whereHas('laporan', function ($query) {
                $query->whereIn('status', [
                    'ditugaskan',
                    'sedang_dikerjakan',
                    'menunggu_verifikasi',
                    'selesai',
                ]);
            })
            ->latest('tanggal_penugasan')
            ->paginate(10);

        $totalTugas = Penugasan::where('teknisi_id', $teknisiId)
            ->whereHas('laporan', function ($query) {
                $query->whereIn('status', [
                    'ditugaskan',
                    'sedang_dikerjakan',
                    'menunggu_verifikasi',
                    'selesai',
                ]);
            })
            ->count();

        $totalMenunggu = Penugasan::where('teknisi_id', $teknisiId)
            ->whereHas('laporan', function ($query) {
                $query->where('status', 'ditugaskan');
            })
            ->count();

        $totalDikerjakan = Penugasan::where('teknisi_id', $teknisiId)
            ->whereHas('laporan', function ($query) {
                $query->where('status', 'sedang_dikerjakan');
            })
            ->count();

        $totalSelesai = Penugasan::where('teknisi_id', $teknisiId)
            ->whereHas('laporan', function ($query) {
                $query->where('status', 'selesai');
            })
            ->count();

        return view('teknisi.dashboard', compact(
            'penugasans',
            'totalTugas',
            'totalMenunggu',
            'totalDikerjakan',
            'totalSelesai'
        ));
    }

    /**
     * Menampilkan detail tugas teknisi.
     */
    public function show(Laporan $laporan)
    {
        $penugasan = Penugasan::with([
            'teknisi',
            'pemberiTugas',
        ])
            ->where('laporan_id', $laporan->id)
            ->where('teknisi_id', auth()->id())
            ->latest('tanggal_penugasan')
            ->first();

        abort_unless(
            $penugasan,
            403,
            'Anda tidak memiliki akses terhadap tugas ini.'
        );

        $laporan->load([
            'pelapor.unit',
            'gedung',
            'kategori',
            'fotos',
            'riwayat.pengguna',
            'penugasan.teknisi',
            'verifikasi.verifikator',
        ]);

        return view('teknisi.tugas.show', compact(
            'laporan',
            'penugasan'
        ));
    }

    /**
     * Memulai pengerjaan laporan.
     */
    public function start(Laporan $laporan)
    {
        DB::transaction(function () use ($laporan) {

            $laporanTerkunci = Laporan::whereKey($laporan->id)
                ->lockForUpdate()
                ->firstOrFail();

            $penugasan = Penugasan::where('laporan_id', $laporanTerkunci->id)
                ->where('teknisi_id', auth()->id())
                ->latest('tanggal_penugasan')
                ->first();

            abort_unless(
                $penugasan,
                403,
                'Anda bukan teknisi yang ditugaskan pada laporan ini.'
            );

            if ($laporanTerkunci->status !== 'ditugaskan') {
                throw ValidationException::withMessages([
                    'status' => 'Laporan ini tidak dapat dimulai karena statusnya bukan ditugaskan.',
                ]);
            }

            $oldStatus = $laporanTerkunci->status;

            $laporanTerkunci->update([
                'status' => 'sedang_dikerjakan',
            ]);

            $penugasan->update([
                'mulai_dikerjakan' => now(),
            ]);

            RiwayatStatus::create([
                'laporan_id' => $laporanTerkunci->id,
                'status_sebelumnya' => $oldStatus,
                'status_baru' => 'sedang_dikerjakan',
                'user_id' => auth()->id(),
                'keterangan' => 'Teknisi mulai melakukan pengerjaan laporan.',
            ]);
        });

        return redirect()
            ->route('teknisi.tugas.show', $laporan)
            ->with('success', 'Pengerjaan laporan berhasil dimulai.');
    }

    /**
     * Mengirim hasil pekerjaan kepada UPA untuk diverifikasi.
     */
    public function complete(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'catatan_hasil' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'foto' => [
                'required',
                'array',
                'min:1',
                'max:5',
            ],
            'foto.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'foto.required' => 'Unggah minimal satu foto hasil perbaikan.',
            'foto.min' => 'Unggah minimal satu foto hasil perbaikan.',
            'foto.max' => 'Maksimal lima foto hasil perbaikan.',
            'foto.*.image' => 'File harus berupa gambar.',
            'foto.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
        ]);

        $filePaths = [];

        try {
            DB::transaction(function () use (
                $laporan,
                $validated,
                $request,
                &$filePaths
            ) {
                $laporanTerkunci = Laporan::whereKey($laporan->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $penugasan = Penugasan::where('laporan_id', $laporanTerkunci->id)
                    ->where('teknisi_id', auth()->id())
                    ->latest('tanggal_penugasan')
                    ->first();

                abort_unless(
                    $penugasan,
                    403,
                    'Anda bukan teknisi yang ditugaskan pada laporan ini.'
                );

                if ($laporanTerkunci->status !== 'sedang_dikerjakan') {
                    throw ValidationException::withMessages([
                        'status' => 'Laporan harus berstatus sedang dikerjakan sebelum dikirim untuk verifikasi.',
                    ]);
                }

                // Simpan foto hasil perbaikan.
                foreach ($request->file('foto', []) as $file) {
                    $path = $file->store(
                        'laporan/hasil-perbaikan',
                        'public'
                    );

                    $filePaths[] = $path;

                    LaporanFoto::create([
                        'laporan_id' => $laporanTerkunci->id,
                        'jenis_foto' => 'hasil_perbaikan',
                        'nama_file' => $file->getClientOriginalName(),
                        'path' => $path,
                        'uploaded_by' => auth()->id(),
                    ]);
                }

                $oldStatus = $laporanTerkunci->status;

                // Ubah status menjadi menunggu verifikasi UPA.
                $laporanTerkunci->update([
                    'status' => 'menunggu_verifikasi',
                ]);

                // Simpan waktu penyelesaian oleh teknisi.
                $penugasan->update([
                    'selesai_dikerjakan' => now(),
                ]);

                // Catat riwayat status.
                RiwayatStatus::create([
                    'laporan_id' => $laporanTerkunci->id,
                    'status_sebelumnya' => $oldStatus,
                    'status_baru' => 'menunggu_verifikasi',
                    'user_id' => auth()->id(),
                    'keterangan' => $validated['catatan_hasil']
                        ?: 'Teknisi telah menyelesaikan pekerjaan dan mengirim hasil perbaikan untuk diverifikasi UPA.',
                ]);
            });
        } catch (\Throwable $exception) {
            // Hapus file jika transaksi database gagal.
            foreach ($filePaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $exception;
        }

        return redirect()
            ->route('teknisi.tugas.show', $laporan)
            ->with(
                'success',
                'Hasil pekerjaan berhasil dikirim dan menunggu verifikasi UPA.'
            );
    }
}
