
@extends('layouts.app')

@section('title', 'Dashboard Kepala UPA')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <p class="text-sm font-semibold text-blue-700">
            UPA Perawatan dan Perbaikan
        </p>

        <h1 class="mt-1 text-2xl font-bold text-gray-900">
            Dashboard Kepala UPA
        </h1>

        <p class="mt-2 text-sm text-gray-500">
            Kelola laporan kerusakan, penugasan teknisi, dan verifikasi hasil pekerjaan.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Laporan masuk --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Laporan Masuk</p>
                    <h3 class="mt-2 text-3xl font-bold text-blue-700">
                        {{ $totalLaporanMasuk ?? 0 }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">
                        Menunggu penanganan
                    </p>
                </div>

                <div class="rounded-xl bg-blue-100 p-3 text-blue-700">
                    <i class="fas fa-inbox text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Menunggu penugasan --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Menunggu Penugasan</p>
                    <h3 class="mt-2 text-3xl font-bold text-yellow-600">
                        {{ $totalMenungguPenugasan ?? 0 }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">
                        Belum memiliki teknisi
                    </p>
                </div>

                <div class="rounded-xl bg-yellow-100 p-3 text-yellow-600">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Sedang dikerjakan --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Sedang Dikerjakan</p>
                    <h3 class="mt-2 text-3xl font-bold text-purple-600">
                        {{ $totalSedangDikerjakan ?? 0 }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">
                        Dalam penanganan teknisi
                    </p>
                </div>

                <div class="rounded-xl bg-purple-100 p-3 text-purple-600">
                    <i class="fas fa-tools text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Menunggu verifikasi --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
                    <h3 class="mt-2 text-3xl font-bold text-orange-600">
                        {{ $totalMenungguVerifikasi ?? 0 }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">
                        Perlu pemeriksaan hasil
                    </p>
                </div>

                <div class="rounded-xl bg-orange-100 p-3 text-orange-600">
                    <i class="fas fa-clipboard-check text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Laporan perlu ditangani --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-gray-200 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Laporan Perlu Ditangani
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Laporan yang telah disetujui Wadir II dan menunggu proses UPA.
                </p>
            </div>

            <a href="{{ route('upa.laporan.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-900">
                Lihat Semua
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if(isset($laporans) && $laporans->count())

            {{-- Desktop --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-5 py-4">No. Tiket</th>
                            <th class="px-5 py-4">Pelapor</th>
                            <th class="px-5 py-4">Laporan</th>
                            <th class="px-5 py-4">Lokasi</th>
                            <th class="px-5 py-4">Tanggal</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($laporans as $laporan)
                            <tr class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="font-semibold text-blue-700">
                                        {{ $laporan->nomor_tiket }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">
                                        {{ $laporan->pelapor->name ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->pelapor->unit->nama_unit ?? '-' }}
                                    </p>
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">
                                        {{ $laporan->judul_laporan }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->kategori->nama_kategori ?? '-' }}
                                    </p>
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    <p>{{ $laporan->gedung->nama_gedung ?? '-' }}</p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->lokasi_detail }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $laporan->created_at?->format('d/m/Y') }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    @if($laporan->status === 'disetujui' || $laporan->status === 'menunggu_penanganan_upa')
                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Menunggu Penugasan
                                        </span>
                                    @elseif($laporan->status === 'ditugaskan')
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                            Ditugaskan
                                        </span>
                                    @elseif($laporan->status === 'sedang_dikerjakan')
                                        <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                            Sedang Dikerjakan
                                        </span>
                                    @elseif($laporan->status === 'menunggu_verifikasi')
                                        <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($laporan->status === 'selesai')
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Selesai
                                        </span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <a href="{{ route('upa.laporan.show', $laporan) }}"
                                       class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-800">
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile --}}
            <div class="space-y-4 p-4 md:hidden">
                @foreach($laporans as $laporan)
                    <div class="rounded-xl border border-gray-200 p-4">

                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold text-blue-700">
                                    {{ $laporan->nomor_tiket }}
                                </p>

                                <h3 class="mt-2 font-semibold text-gray-900">
                                    {{ $laporan->judul_laporan }}
                                </h3>
                            </div>

                            <span class="shrink-0 rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-700">
                                {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                            </span>
                        </div>

                        <div class="mt-3 space-y-2 text-sm text-gray-600">
                            <p>
                                <i class="fas fa-user mr-2 w-4 text-gray-400"></i>
                                {{ $laporan->pelapor->name ?? '-' }}
                            </p>

                            <p>
                                <i class="fas fa-building mr-2 w-4 text-gray-400"></i>
                                {{ $laporan->gedung->nama_gedung ?? '-' }}
                            </p>

                            <p>
                                <i class="fas fa-map-marker-alt mr-2 w-4 text-gray-400"></i>
                                {{ $laporan->lokasi_detail }}
                            </p>
                        </div>

                        <a href="{{ route('upa.laporan.show', $laporan) }}"
                           class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                            <i class="fas fa-eye"></i>
                            Periksa Laporan
                        </a>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 px-5 py-4">
                {{ $laporans->links() }}
            </div>

        @else

            <div class="px-5 py-16 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>

                <h3 class="mt-4 font-semibold text-gray-900">
                    Belum Ada Laporan
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Belum ada laporan yang perlu ditangani oleh UPA.
                </p>
            </div>

        @endif

    </div>

</div>
@endsection
