
@extends('layouts.app')

@section('title', 'Dashboard Pelapor')
@section('page-title', 'Dashboard Pelapor')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">
                Selamat Datang, {{ auth()->user()->name }}!
            </h1>
            <p class="text-gray-500 mt-1">
                Pantau laporan kerusakan dan layanan perawatan fasilitas kampus.
            </p>
        </div>


    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        @php
            $statistik = [
                [
                    'judul' => 'Total Laporan',
                    'jumlah' => $totalLaporan ?? 0,
                    'icon' => 'fa-file-alt',
                    'warna' => 'blue'
                ],
                [
                    'judul' => 'Menunggu Persetujuan',
                    'jumlah' => $menungguPersetujuan ?? 0,
                    'icon' => 'fa-clock',
                    'warna' => 'yellow'
                ],
                [
                    'judul' => 'Sedang Diproses',
                    'jumlah' => $sedangDitangani ?? 0,
                    'icon' => 'fa-tools',
                    'warna' => 'purple'
                ],
                [
                    'judul' => 'Selesai',
                    'jumlah' => $selesai ?? 0,
                    'icon' => 'fa-check-circle',
                    'warna' => 'green'
                ],
            ];
        @endphp

        @foreach($statistik as $item)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            {{ $item['judul'] }}
                        </p>

                        <h3 class="text-3xl font-extrabold text-gray-900 mt-3">
                            {{ $item['jumlah'] }}
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-{{ $item['warna'] }}-50 text-{{ $item['warna'] }}-600 flex items-center justify-center">
                        <i class="fas {{ $item['icon'] }} text-xl"></i>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- INFORMASI ALUR --}}
    <div class="bg-primary rounded-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="relative z-10 max-w-2xl">
            <p class="text-blue-200 text-sm font-semibold uppercase tracking-wider">
                Layanan UPA
            </p>

            <h2 class="text-2xl font-bold mt-2">
                Laporkan Kerusakan Fasilitas Kampus
            </h2>

            <p class="text-blue-100 mt-3 leading-relaxed">
                Sampaikan laporan kerusakan fasilitas kampus melalui sistem ini.
                Laporan akan melalui persetujuan Wakil Direktur II sebelum
                diteruskan kepada UPA untuk ditangani.
            </p>

            <a href="{{ route('pelapor.laporan.create') }}"
               class="inline-flex items-center gap-2 mt-5 bg-white text-primary px-5 py-3 rounded-xl font-bold hover:bg-blue-50 transition">
                Buat Laporan Sekarang
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <i class="fas fa-tools absolute right-8 bottom-0 text-white opacity-10 text-9xl"></i>
    </div>

    {{-- DAFTAR LAPORAN --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Riwayat Laporan Saya
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Daftar laporan kerusakan yang pernah kamu kirim.
                </p>
            </div>

            <a href="{{ route('pelapor.laporan.create') }}"
               class="text-primary text-sm font-semibold hover:underline">
                + Laporan Baru
            </a>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Nomor Tiket</th>
                        <th class="px-6 py-4">Judul Laporan</th>
                        <th class="px-6 py-4">Gedung</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Detail</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($laporans as $laporan)

                        @php
                            $status = [
                                'laporan_baru' => ['Laporan Baru', 'bg-gray-100 text-gray-700'],
                                'menunggu_persetujuan_wadir_ii' => ['Menunggu Persetujuan', 'bg-yellow-100 text-yellow-700'],
                                'ditolak' => ['Ditolak', 'bg-red-100 text-red-700'],
                                'disetujui' => ['Disetujui', 'bg-blue-100 text-blue-700'],
                                'menunggu_penanganan_upa' => ['Menunggu Penanganan UPA', 'bg-yellow-100 text-yellow-700'],
                                'ditugaskan' => ['Ditugaskan', 'bg-indigo-100 text-indigo-700'],
                                'sedang_dikerjakan' => ['Sedang Dikerjakan', 'bg-purple-100 text-purple-700'],
                                'menunggu_verifikasi' => ['Menunggu Verifikasi', 'bg-orange-100 text-orange-700'],
                                'selesai' => ['Selesai', 'bg-green-100 text-green-700'],
                            ];

                            $statusInfo = $status[$laporan->status] ?? [
                                ucfirst(str_replace('_', ' ', $laporan->status)),
                                'bg-gray-100 text-gray-700'
                            ];
                        @endphp

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4">
                                <span class="font-bold text-primary">
                                    {{ $laporan->nomor_tiket }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800">
                                    {{ $laporan->judul_laporan }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $laporan->kategori->nama_kategori ?? '-' }}
                                </p>
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $laporan->gedung->nama_gedung ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                {{ $laporan->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $statusInfo[1] }}">
                                    {{ $statusInfo[0] }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('pelapor.laporan.show', $laporan->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 text-primary hover:bg-primary hover:text-white transition"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">

                                <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-folder-open text-2xl"></i>
                                </div>

                                <h3 class="font-bold text-gray-700">
                                    Belum Ada Laporan
                                </h3>

                                <p class="text-sm text-gray-400 mt-2">
                                    Kamu belum mengirim laporan kerusakan.
                                </p>

                                <a href="{{ route('pelapor.laporan.create') }}"
                                   class="inline-flex mt-5 items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-secondary transition">
                                    <i class="fas fa-plus"></i>
                                    Buat Laporan
                                </a>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($laporans->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $laporans->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
