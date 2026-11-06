
@extends('layouts.app')

@section('title', 'Data Laporan - UPA')
@section('page-title', 'Data Laporan')

@section('content')

@php
    $statusLabels = [
        'disetujui' => 'Disetujui',
        'menunggu_penanganan_upa' => 'Menunggu Penanganan',
        'ditugaskan' => 'Ditugaskan',
        'sedang_dikerjakan' => 'Sedang Dikerjakan',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'selesai' => 'Selesai',
    ];

    $statusColors = [
        'disetujui' => 'bg-green-100 text-green-700',
        'menunggu_penanganan_upa' => 'bg-yellow-100 text-yellow-700',
        'ditugaskan' => 'bg-blue-100 text-blue-700',
        'sedang_dikerjakan' => 'bg-purple-100 text-purple-700',
        'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
        'selesai' => 'bg-emerald-100 text-emerald-700',
    ];
@endphp

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Data Laporan Kerusakan
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola laporan kerusakan, penugasan teknisi, dan verifikasi hasil perbaikan.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
            <i class="fas fa-clipboard-list"></i>
            Total: {{ $laporans->total() }} Laporan
        </div>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            <i class="fas fa-check-circle mt-0.5"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <i class="fas fa-exclamation-circle mt-0.5"></i>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-semibold">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Terdapat kesalahan:
            </p>

            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- FILTER DAN PENCARIAN --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <form action="{{ route('upa.laporan.index') }}"
              method="GET"
              class="grid grid-cols-1 gap-4 md:grid-cols-12">

            {{-- PENCARIAN --}}
            <div class="md:col-span-6">

                <label for="search"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Cari Laporan
                </label>

                <div class="relative">

                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor tiket, judul, atau nama pelapor..."
                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    >

                </div>

            </div>


            {{-- FILTER STATUS --}}
            <div class="md:col-span-4">

                <label for="status"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Filter Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                >

                    <option value="">Semua Status</option>

                    @foreach($statusLabels as $value => $label)
                        <option value="{{ $value }}"
                            @selected(request('status') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach

                </select>

            </div>


            {{-- TOMBOL --}}
            <div class="flex items-end gap-2 md:col-span-2">

                <button type="submit"
                        class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800">

                    <i class="fas fa-filter"></i>
                    Filter

                </button>

                <a href="{{ route('upa.laporan.index') }}"
                   class="flex h-[42px] w-11 shrink-0 items-center justify-center rounded-lg border border-gray-300 text-gray-600 transition hover:bg-gray-100"
                   title="Reset filter">

                    <i class="fas fa-rotate-left"></i>

                </a>

            </div>

        </form>

    </div>


    {{-- DAFTAR LAPORAN --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-2 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <h2 class="font-bold text-gray-900">
                <i class="fas fa-list mr-2 text-blue-700"></i>
                Daftar Laporan
            </h2>

            <p class="text-xs text-gray-500">
                Menampilkan
                {{ $laporans->firstItem() ?? 0 }} -
                {{ $laporans->lastItem() ?? 0 }}
                dari {{ $laporans->total() }} laporan
            </p>

        </div>


        @if($laporans->isNotEmpty())

            {{-- TABEL DESKTOP --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="w-full min-w-[1000px] text-left">

                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">

                        <tr>
                            <th class="px-5 py-4 font-semibold">No.</th>
                            <th class="px-5 py-4 font-semibold">Informasi Laporan</th>
                            <th class="px-5 py-4 font-semibold">Pelapor</th>
                            <th class="px-5 py-4 font-semibold">Lokasi</th>
                            <th class="px-5 py-4 font-semibold">Teknisi</th>
                            <th class="px-5 py-4 font-semibold">Status</th>
                            <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($laporans as $index => $laporan)

                            @php
                                $penugasan = $laporan->penugasan;
                            @endphp

                            <tr class="transition hover:bg-gray-50">

                                {{-- NOMOR --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">
                                    {{ $laporans->firstItem() + $index }}
                                </td>


                                {{-- INFORMASI LAPORAN --}}
                                <td class="px-5 py-4">

                                    <p class="font-semibold text-gray-900">
                                        {{ $laporan->judul_laporan }}
                                    </p>

                                    <p class="mt-1 text-xs font-medium text-blue-700">
                                        {{ $laporan->nomor_tiket }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->kategori?->nama_kategori ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        <i class="far fa-calendar mr-1"></i>
                                        {{ $laporan->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </p>

                                </td>


                                {{-- PELAPOR --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $laporan->pelapor?->name ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->pelapor?->unit?->nama_unit ?? 'Unit tidak tersedia' }}
                                    </p>

                                </td>


                                {{-- LOKASI --}}
                                <td class="px-5 py-4">

                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $laporan->gedung?->nama_gedung ?? '-' }}
                                    </p>

                                    <p class="mt-1 max-w-[180px] truncate text-xs text-gray-500"
                                       title="{{ $laporan->lokasi_detail }}">
                                        {{ $laporan->lokasi_detail ?: '-' }}
                                    </p>

                                </td>


                                {{-- TEKNISI --}}
                                <td class="px-5 py-4">

                                    @if($penugasan?->teknisi)

                                        <div class="flex items-center gap-2">

                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">
                                                {{ strtoupper(substr($penugasan->teknisi->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">
                                                    {{ $penugasan->teknisi->name }}
                                                </p>

                                                <p class="text-xs text-gray-400">
                                                    Teknisi
                                                </p>
                                            </div>

                                        </div>

                                    @else

                                        <span class="text-xs italic text-gray-400">
                                            Belum ditugaskan
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-4">

                                    <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-semibold
                                        {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-700' }}">

                                        {{ $statusLabels[$laporan->status] ?? str_replace('_', ' ', ucfirst($laporan->status)) }}

                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td class="px-5 py-4 text-center">

                                    <a href="{{ route('upa.laporan.show', $laporan) }}"
                                       class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-700 hover:text-white">

                                        <i class="fas fa-eye"></i>
                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- KARTU MOBILE --}}
            <div class="divide-y divide-gray-100 md:hidden">

                @foreach($laporans as $laporan)

                    @php
                        $penugasan = $laporan->penugasan;
                    @endphp

                    <div class="space-y-4 p-5">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <p class="text-xs font-semibold text-blue-700">
                                    {{ $laporan->nomor_tiket }}
                                </p>

                                <h3 class="mt-1 font-bold text-gray-900">
                                    {{ $laporan->judul_laporan }}
                                </h3>

                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $laporan->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </p>

                            </div>

                            <span class="shrink-0 rounded-full px-3 py-1.5 text-[10px] font-semibold
                                {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-700' }}">

                                {{ $statusLabels[$laporan->status] ?? str_replace('_', ' ', ucfirst($laporan->status)) }}

                            </span>

                        </div>


                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <p class="text-xs text-gray-400">
                                    Pelapor
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-800">
                                    {{ $laporan->pelapor?->name ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-400">
                                    Gedung
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-800">
                                    {{ $laporan->gedung?->nama_gedung ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-400">
                                    Kategori
                                </p>

                                <p class="mt-1 text-sm text-gray-800">
                                    {{ $laporan->kategori?->nama_kategori ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-400">
                                    Teknisi
                                </p>

                                <p class="mt-1 text-sm text-gray-800">
                                    {{ $penugasan?->teknisi?->name ?? 'Belum ditugaskan' }}
                                </p>
                            </div>

                        </div>


                        <div class="border-t border-gray-100 pt-3">

                            <p class="text-xs text-gray-400">
                                Lokasi Detail
                            </p>

                            <p class="mt-1 text-sm text-gray-700">
                                {{ $laporan->lokasi_detail ?: '-' }}
                            </p>

                        </div>


                        <a href="{{ route('upa.laporan.show', $laporan) }}"
                           class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">

                            <i class="fas fa-eye"></i>
                            Lihat Detail Laporan

                        </a>

                    </div>

                @endforeach

            </div>


            {{-- PAGINATION --}}
            @if($laporans->hasPages())

                <div class="border-t border-gray-200 px-5 py-4">

                    {{ $laporans->links() }}

                </div>

            @endif


        @else

            {{-- DATA KOSONG --}}
            <div class="px-5 py-16 text-center">

                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-blue-50">

                    <i class="fas fa-folder-open text-3xl text-blue-300"></i>

                </div>

                <h3 class="mt-5 text-lg font-bold text-gray-800">
                    Tidak Ada Laporan
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-gray-500">

                    @if(request()->filled('search') || request()->filled('status'))
                        Tidak ditemukan laporan yang sesuai dengan pencarian atau filter yang dipilih.
                    @else
                        Belum ada laporan yang masuk ke bagian UPA untuk ditangani.
                    @endif

                </p>

                @if(request()->filled('search') || request()->filled('status'))

                    <a href="{{ route('upa.laporan.index') }}"
                       class="mt-5 inline-flex items-center gap-2 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">

                        <i class="fas fa-rotate-left"></i>
                        Reset Pencarian

                    </a>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection
