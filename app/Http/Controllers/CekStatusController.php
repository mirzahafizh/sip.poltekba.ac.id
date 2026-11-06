<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class CekStatusController extends Controller
{
    public function index()
    {
        return view('landing.cek-status');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'nomor_tiket' => ['required', 'string', 'max:100'],
        ]);

        $laporan = Laporan::with(['gedung', 'kategori', 'riwayat'])
            ->where('nomor_tiket', $validated['nomor_tiket'])
            ->first();

        if (! $laporan) {
            return back()->withErrors([
                'nomor_tiket' => 'Nomor tiket tidak ditemukan.',
            ])->withInput();
        }

        // Halaman publik hanya menampilkan ringkasan, tanpa identitas dan uraian sensitif.
        return view('landing.hasil-status', compact('laporan'));
    }
}
