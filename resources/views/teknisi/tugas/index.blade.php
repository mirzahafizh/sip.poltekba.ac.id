
@extends('layouts.app')

@section('title', 'Daftar Tugas Teknisi')

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
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Daftar Tugas Saya
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola dan pantau seluruh pekerjaan perawatan dan perbaikan yang ditugaskan kepada Anda.
            </p>
        </div>

        <a href="{{ route('teknisi.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            <i class="fas fa-chart-pie"></i>
            Dashboard
        </a>
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
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <form action="{{ route('teknisi.tugas.index') }}"
              method="GET"
              class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <div class="md:col-span-2">
                <label for="search" class="mb-2 block text-sm font-semibold text-gray-700">
                    Cari Tugas
                </label>

                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor tiket, judul laporan, atau nama gedung..."
                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-gray-700">
                    Filter Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                >
                    <option value="">Semua Status</option>

                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" @selected(request('status') === $key)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap gap-2 md:col-span-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                    <i class="fas fa-filter"></i>
                    Terapkan Filter
                </button>

                <a href="{{ route('teknisi.tugas.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-undo"></i>
                    Reset
                </a>
            </div>

        </form>
    </div>

    {{-- Tabel tugas --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <div>
                <h2 class="font-bold text-gray-900">
                    Seluruh Tugas
                </h2>

                <p class="mt-1 text-xs text-gray-500">
                    Daftar pekerjaan yang pernah dan sedang ditugaskan kepada Anda.
                </p>
            </div>

            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                {{ $penugasans->total() }} Tugas
            </span>
        </div>

        @if($penugasans->count())

            {{-- Desktop --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-5 py-4">No.</th>
                            <th class="px-5 py-4">Nomor Tiket</th>
                            <th class="px-5 py-4">Judul Laporan</th>
                            <th class="px-5 py-4">Lokasi</th>
                            <th class="px-5 py-4">Tanggal Tugas</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($penugasans as $index => $penugasan)

                            @php
                                $laporan = $penugasan->laporan;
                            @endphp

                            @if($laporan)
                                <tr class="hover:bg-gray-50">

                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $penugasans->firstItem() + $index }}
                                    </td>

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
                                            Detail
                                        </a>
                                    </td>

                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile --}}
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
                               class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
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
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>

                <h3 class="mt-4 font-semibold text-gray-900">
                    Tugas Tidak Ditemukan
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">
                    Belum ada tugas yang sesuai dengan pencarian atau filter yang Anda pilih.
                </p>

                <a href="{{ route('teknisi.tugas.index') }}"
                   class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-900">
                    <i class="fas fa-undo"></i>
                    Tampilkan Semua Tugas
                </a>
            </div>

        @endif

    </div>

</div>

@endsection
