
@extends('layouts.app')

@section('title', 'Dashboard Teknisi')

@section('content')

@php
    $statusLabels = [
        'ditugaskan' => 'Menunggu Pengerjaan',
        'sedang_dikerjakan' => 'Sedang Dikerjakan',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'selesai' => 'Selesai',
    ];

    $statusColors = [
        'ditugaskan' => 'bg-yellow-100 text-yellow-700',
        'sedang_dikerjakan' => 'bg-blue-100 text-blue-700',
        'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
        'selesai' => 'bg-green-100 text-green-700',
    ];
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Dashboard Teknisi
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Selamat datang, {{ auth()->user()->name }}.
            Berikut daftar tugas perawatan dan perbaikan yang diberikan kepada Anda.
        </p>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Tugas</p>
                    <h2 class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $totalTugas }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Menunggu Pengerjaan</p>
                    <h2 class="mt-2 text-3xl font-bold text-yellow-600">
                        {{ $totalMenunggu }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-100 text-yellow-700">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Sedang Dikerjakan</p>
                    <h2 class="mt-2 text-3xl font-bold text-blue-600">
                        {{ $totalDikerjakan }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <i class="fas fa-tools text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pekerjaan Selesai</p>
                    <h2 class="mt-2 text-3xl font-bold text-green-600">
                        {{ $totalSelesai }}
                    </h2>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Daftar Tugas --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-gray-900">
                    Daftar Tugas Saya
                </h2>

                <p class="mt-1 text-xs text-gray-500">
                    Laporan kerusakan yang ditugaskan kepada Anda.
                </p>
            </div>

            <span class="text-sm text-gray-500">
                {{ $penugasans->total() }} tugas
            </span>
        </div>

        @if($penugasans->count())

            {{-- Tampilan desktop --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-5 py-4">Nomor Tiket</th>
                            <th class="px-5 py-4">Laporan</th>
                            <th class="px-5 py-4">Lokasi</th>
                            <th class="px-5 py-4">Tanggal Tugas</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($penugasans as $penugasan)

                            @php
                                $laporan = $penugasan->laporan;
                            @endphp

                            @if($laporan)
                                <tr class="hover:bg-gray-50">

                                    <td class="whitespace-nowrap px-5 py-4 font-semibold text-blue-700">
                                        {{ $laporan->nomor_tiket }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-gray-900">
                                            {{ $laporan->judul_laporan }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $laporan->kategori->nama_kategori ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="text-gray-800">
                                            {{ $laporan->gedung->nama_gedung ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $laporan->lokasi_detail }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                        {{ $penugasan->tanggal_penugasan?->format('d/m/Y') ?? '-' }}
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $statusLabels[$laporan->status] ?? $laporan->status }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-center">
                                        <a href="{{ route('teknisi.tugas.show', $laporan) }}"
                                           class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-800">
                                            <i class="fas fa-eye"></i>
                                            Detail Tugas
                                        </a>
                                    </td>

                                </tr>
                            @endif

                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- Tampilan mobile --}}
            <div class="divide-y divide-gray-100 md:hidden">

                @foreach($penugasans as $penugasan)

                    @php
                        $laporan = $penugasan->laporan;
                    @endphp

                    @if($laporan)
                        <div class="space-y-3 p-5">

                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold text-blue-700">
                                        {{ $laporan->nomor_tiket }}
                                    </p>

                                    <h3 class="mt-1 font-semibold text-gray-900">
                                        {{ $laporan->judul_laporan }}
                                    </h3>
                                </div>

                                <span class="shrink-0 rounded-full px-2 py-1 text-xs font-semibold {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $statusLabels[$laporan->status] ?? $laporan->status }}
                                </span>
                            </div>

                            <div class="space-y-1 text-sm text-gray-500">
                                <p>
                                    <i class="fas fa-building mr-2 w-4"></i>
                                    {{ $laporan->gedung->nama_gedung ?? '-' }}
                                </p>

                                <p>
                                    <i class="fas fa-map-marker-alt mr-2 w-4"></i>
                                    {{ $laporan->lokasi_detail }}
                                </p>

                                <p>
                                    <i class="fas fa-calendar mr-2 w-4"></i>
                                    {{ $penugasan->tanggal_penugasan?->format('d/m/Y') ?? '-' }}
                                </p>
                            </div>

                            <a href="{{ route('teknisi.tugas.show', $laporan) }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                                <i class="fas fa-eye"></i>
                                Lihat Detail Tugas
                            </a>

                        </div>
                    @endif

                @endforeach

            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 px-5 py-4">
                {{ $penugasans->links() }}
            </div>

        @else

            <div class="px-5 py-16 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>

                <h3 class="mt-4 font-semibold text-gray-900">
                    Belum Ada Tugas
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">
                    Saat ini belum ada laporan kerusakan yang ditugaskan kepada Anda.
                    Silakan periksa kembali nanti.
                </p>
            </div>

        @endif

    </div>

</div>

@endsection
