
@extends('layouts.app')

@section('title', 'Dashboard Wadir II')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <p class="text-sm font-medium text-blue-700">Wakil Direktur II</p>
        <h1 class="mt-1 text-2xl font-bold text-gray-900">
            Dashboard Persetujuan
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Periksa dan berikan persetujuan terhadap laporan kerusakan
            sebelum diteruskan ke UPA Perawatan dan Perbaikan.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                    <h3 class="mt-2 text-3xl font-bold text-yellow-600">
                        {{ $totalMenunggu ?? 0 }}
                    </h3>
                </div>
                <div class="rounded-lg bg-yellow-100 p-3 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Telah Disetujui</p>
                    <h3 class="mt-2 text-3xl font-bold text-green-600">
                        {{ $totalDisetujui ?? 0 }}
                    </h3>
                </div>
                <div class="rounded-lg bg-green-100 p-3 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Ditolak</p>
                    <h3 class="mt-2 text-3xl font-bold text-red-600">
                        {{ $totalDitolak ?? 0 }}
                    </h3>
                </div>
                <div class="rounded-lg bg-red-100 p-3 text-red-600">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Daftar laporan --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-gray-200 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Daftar Laporan Kerusakan
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Laporan yang masuk untuk proses persetujuan Wadir II.
                </p>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                <i class="fas fa-hourglass-half mr-2"></i>
                Perlu Ditinjau
            </span>
        </div>

        @if(isset($laporans) && $laporans->count())

            {{-- Tampilan desktop --}}
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
                                        {{ $laporan->pelapor->unit->nama_unit ?? 'Unit tidak tersedia' }}
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
                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        Menunggu Persetujuan
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <a href="{{ route('wadir.laporan.show', $laporan) }}"
                                       class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-800">
                                        <i class="fas fa-eye"></i>
                                        Periksa
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tampilan mobile --}}
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
                                Menunggu
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
                            <p>
                                <i class="fas fa-calendar mr-2 w-4 text-gray-400"></i>
                                {{ $laporan->created_at?->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <a href="{{ route('wadir.laporan.show', $laporan) }}"
                           class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                            <i class="fas fa-eye"></i>
                            Periksa Laporan
                        </a>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if(method_exists($laporans, 'links'))
                <div class="border-t border-gray-200 px-5 py-4">
                    {{ $laporans->links() }}
                </div>
            @endif

        @else

            <div class="px-5 py-16 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>

                <h3 class="mt-4 font-semibold text-gray-900">
                    Tidak Ada Laporan Menunggu Persetujuan
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Saat ini belum ada laporan kerusakan yang perlu diperiksa.
                </p>
            </div>

        @endif

    </div>

</div>
@endsection
