
@extends('layouts.app')

@section('title', 'Daftar Laporan - Wadir II')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route('wadir.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-700">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">
            Daftar Laporan Kerusakan
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Kelola dan pantau seluruh laporan kerusakan yang masuk.
        </p>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <form action="{{ route('wadir.laporan.index') }}" method="GET"
              class="grid grid-cols-1 gap-4 md:grid-cols-4">

            <div class="md:col-span-2">
                <label for="search" class="mb-2 block text-sm font-medium text-gray-700">
                    Cari Laporan
                </label>

                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor tiket atau judul laporan..."
                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-medium text-gray-700">
                    Filter Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                >
                    <option value="">Semua Status</option>
                    <option value="menunggu_persetujuan_wadir_ii"
                        @selected(request('status') === 'menunggu_persetujuan_wadir_ii')>
                        Menunggu Persetujuan
                    </option>
                    <option value="disetujui"
                        @selected(request('status') === 'disetujui')>
                        Disetujui
                    </option>
                    <option value="ditolak"
                        @selected(request('status') === 'ditolak')>
                        Ditolak
                    </option>
                    <option value="menunggu_penanganan_upa"
                        @selected(request('status') === 'menunggu_penanganan_upa')>
                        Menunggu Penanganan UPA
                    </option>
                    <option value="ditugaskan"
                        @selected(request('status') === 'ditugaskan')>
                        Ditugaskan
                    </option>
                    <option value="sedang_dikerjakan"
                        @selected(request('status') === 'sedang_dikerjakan')>
                        Sedang Dikerjakan
                    </option>
                    <option value="menunggu_verifikasi"
                        @selected(request('status') === 'menunggu_verifikasi')>
                        Menunggu Verifikasi
                    </option>
                    <option value="selesai"
                        @selected(request('status') === 'selesai')>
                        Selesai
                    </option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                        class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>

                <a href="{{ route('wadir.laporan.index') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-redo"></i>
                </a>
            </div>

        </form>
    </div>

    {{-- Tabel laporan --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-2 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-gray-900">
                    Seluruh Laporan
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Daftar laporan berdasarkan waktu terbaru.
                </p>
            </div>

            <span class="text-sm text-gray-500">
                Total: {{ $laporans->total() }} laporan
            </span>
        </div>

        @if($laporans->count())

            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-5 py-4">No.</th>
                            <th class="px-5 py-4">Nomor Tiket</th>
                            <th class="px-5 py-4">Pelapor</th>
                            <th class="px-5 py-4">Judul Laporan</th>
                            <th class="px-5 py-4">Gedung</th>
                            <th class="px-5 py-4">Tanggal</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($laporans as $index => $laporan)
                            @php
                                $statusLabels = [
                                    'laporan_baru' => 'Laporan Baru',
                                    'menunggu_persetujuan_wadir_ii' => 'Menunggu Persetujuan',
                                    'ditolak' => 'Ditolak',
                                    'disetujui' => 'Disetujui',
                                    'menunggu_penanganan_upa' => 'Menunggu Penanganan',
                                    'ditugaskan' => 'Ditugaskan',
                                    'sedang_dikerjakan' => 'Sedang Dikerjakan',
                                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                    'selesai' => 'Selesai',
                                ];

                                $statusColors = [
                                    'laporan_baru' => 'bg-gray-100 text-gray-700',
                                    'menunggu_persetujuan_wadir_ii' => 'bg-yellow-100 text-yellow-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    'disetujui' => 'bg-green-100 text-green-700',
                                    'menunggu_penanganan_upa' => 'bg-blue-100 text-blue-700',
                                    'ditugaskan' => 'bg-indigo-100 text-indigo-700',
                                    'sedang_dikerjakan' => 'bg-purple-100 text-purple-700',
                                    'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                ];
                            @endphp

                            <tr class="transition hover:bg-gray-50">
                                <td class="px-5 py-4 text-gray-500">
                                    {{ $laporans->firstItem() + $index }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-blue-700">
                                    {{ $laporan->nomor_tiket }}
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">
                                        {{ $laporan->pelapor->name ?? '-' }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $laporan->pelapor->unit->nama_unit ?? '-' }}
                                    </p>
                                </td>

                                <td class="max-w-xs truncate px-5 py-4 font-medium text-gray-800">
                                    {{ $laporan->judul_laporan }}
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    {{ $laporan->gedung->nama_gedung ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    {{ $laporan->created_at?->format('d/m/Y') }}
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabels[$laporan->status] ?? ucfirst(str_replace('_', ' ', $laporan->status)) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('wadir.laporan.show', $laporan) }}"
                                       class="inline-flex items-center gap-2 rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-5 py-4">
                {{ $laporans->withQueryString()->links() }}
            </div>

        @else

            <div class="px-5 py-16 text-center">
                <i class="fas fa-folder-open text-4xl text-gray-300"></i>
                <h3 class="mt-4 font-semibold text-gray-900">
                    Laporan Tidak Ditemukan
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    Belum ada laporan yang sesuai dengan pencarian atau filter.
                </p>
            </div>

        @endif

    </div>

</div>
@endsection
