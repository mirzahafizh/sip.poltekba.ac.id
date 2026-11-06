
@extends('layouts.app')

@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan')

@section('content')

@php
    $statusList = [
        'laporan_baru' => [
            'label' => 'Laporan Baru',
            'color' => 'bg-gray-100 text-gray-700',
            'description' => 'Laporan berhasil dibuat.'
        ],
        'menunggu_persetujuan_wadir_ii' => [
            'label' => 'Menunggu Persetujuan Wadir II',
            'color' => 'bg-yellow-100 text-yellow-700',
            'description' => 'Laporan sedang menunggu persetujuan Wakil Direktur II.'
        ],
        'ditolak' => [
            'label' => 'Ditolak',
            'color' => 'bg-red-100 text-red-700',
            'description' => 'Laporan tidak disetujui.'
        ],
        'disetujui' => [
            'label' => 'Disetujui',
            'color' => 'bg-blue-100 text-blue-700',
            'description' => 'Laporan telah disetujui dan dapat ditangani UPA.'
        ],
        'menunggu_penanganan_upa' => [
            'label' => 'Menunggu Penanganan UPA',
            'color' => 'bg-yellow-100 text-yellow-700',
            'description' => 'Laporan menunggu proses penanganan UPA.'
        ],
        'ditugaskan' => [
            'label' => 'Ditugaskan',
            'color' => 'bg-indigo-100 text-indigo-700',
            'description' => 'Teknisi telah ditugaskan untuk menangani laporan.'
        ],
        'sedang_dikerjakan' => [
            'label' => 'Sedang Dikerjakan',
            'color' => 'bg-purple-100 text-purple-700',
            'description' => 'Teknisi sedang melakukan pekerjaan perbaikan.'
        ],
        'menunggu_verifikasi' => [
            'label' => 'Menunggu Verifikasi',
            'color' => 'bg-orange-100 text-orange-700',
            'description' => 'Pekerjaan menunggu pemeriksaan UPA.'
        ],
        'selesai' => [
            'label' => 'Selesai',
            'color' => 'bg-green-100 text-green-700',
            'description' => 'Laporan telah selesai ditangani dan diverifikasi UPA.'
        ],
    ];

    $statusSekarang = $statusList[$laporan->status] ?? [
        'label' => ucfirst(str_replace('_', ' ', $laporan->status)),
        'color' => 'bg-gray-100 text-gray-700',
        'description' => 'Status laporan sedang diproses.'
    ];
@endphp

<div class="max-w-6xl mx-auto space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('pelapor.dashboard') }}" class="hover:text-primary">
            Dashboard
        </a>

        <i class="fas fa-chevron-right text-xs"></i>

        <span class="text-primary font-semibold">
            Detail Laporan
        </span>
    </div>

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">
                Detail Laporan Kerusakan
            </h1>

            <p class="text-gray-500 mt-2">
                Informasi dan perkembangan penanganan laporan kamu.
            </p>
        </div>

        <a href="{{ route('pelapor.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

    </div>

    {{-- NOMOR TIKET DAN STATUS --}}
    <div class="bg-primary rounded-2xl p-6 md:p-8 text-white">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

            <div>
                <p class="text-blue-200 text-sm font-medium">
                    Nomor Tiket Laporan
                </p>

                <h2 class="text-2xl md:text-3xl font-extrabold mt-2">
                    {{ $laporan->nomor_tiket }}
                </h2>

                <p class="text-blue-200 text-sm mt-3">
                    Dibuat pada
                    {{ $laporan->created_at->format('d F Y, H:i') }}
                </p>
            </div>

            <div>
                <p class="text-blue-200 text-sm mb-2">
                    Status Saat Ini
                </p>

                <span class="inline-flex px-4 py-2 rounded-full bg-white text-primary text-sm font-bold">
                    {{ $statusSekarang['label'] }}
                </span>
            </div>

        </div>

    </div>

    {{-- PENOLAKAN --}}
    @if($laporan->status === 'ditolak')
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6">

            <div class="flex gap-3">
                <div class="text-red-600 text-xl">
                    <i class="fas fa-exclamation-circle"></i>
                </div>

                <div>
                    <h3 class="font-bold text-red-800">
                        Laporan Tidak Disetujui
                    </h3>

                    <p class="text-sm text-red-700 mt-2">
                        {{ $laporan->catatan_penolakan ?: 'Tidak ada catatan penolakan.' }}
                    </p>
                </div>
            </div>

        </div>
    @endif

    {{-- INFORMASI STATUS --}}
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">

        <h2 class="font-bold text-lg text-gray-900 mb-3">
            Status Penanganan
        </h2>

        <div class="flex items-start gap-3">

            <div class="w-10 h-10 rounded-xl bg-blue-50 text-primary flex items-center justify-center shrink-0">
                <i class="fas fa-info-circle"></i>
            </div>

            <div>
                <p class="font-semibold text-gray-800">
                    {{ $statusSekarang['label'] }}
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $statusSekarang['description'] }}
                </p>
            </div>

        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- DETAIL LAPORAN --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="font-bold text-lg text-gray-900">
                        <i class="fas fa-file-alt text-primary mr-2"></i>
                        Informasi Kerusakan
                    </h2>
                </div>

                <div class="p-6 space-y-5">

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-400">
                            Judul Laporan
                        </p>

                        <p class="font-bold text-gray-900 text-lg mt-2">
                            {{ $laporan->judul_laporan }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-400">
                                Gedung
                            </p>

                            <p class="font-semibold text-gray-800 mt-2">
                                <i class="fas fa-building text-primary mr-2"></i>
                                {{ $laporan->gedung->nama_gedung ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-400">
                                Kategori Kerusakan
                            </p>

                            <p class="font-semibold text-gray-800 mt-2">
                                <i class="fas fa-tools text-primary mr-2"></i>
                                {{ $laporan->kategori->nama_kategori ?? '-' }}
                            </p>
                        </div>

                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-400">
                            Lokasi Detail
                        </p>

                        <p class="font-semibold text-gray-800 mt-2">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                            {{ $laporan->lokasi_detail }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-400">
                            Deskripsi Kerusakan
                        </p>

                        <p class="text-gray-700 mt-2 leading-relaxed whitespace-pre-line">
                            {{ $laporan->deskripsi }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- FOTO --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="font-bold text-lg text-gray-900">
                        <i class="fas fa-images text-primary mr-2"></i>
                        Dokumentasi Foto
                    </h2>
                </div>

                <div class="p-6">

                    @php
                        $fotoKerusakan = $laporan->fotos->where('jenis_foto', 'kerusakan');
                        $fotoHasil = $laporan->fotos->where('jenis_foto', 'hasil_perbaikan');
                    @endphp

                    <h3 class="font-semibold text-gray-700 mb-4">
                        Foto Sebelum Perbaikan
                    </h3>

                    @if($fotoKerusakan->count())
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">

                            @foreach($fotoKerusakan as $foto)
                                <a href="{{ asset('storage/' . $foto->path) }}"
                                   target="_blank"
                                   class="group rounded-xl overflow-hidden border border-gray-200">

                                    <img src="{{ asset('storage/' . $foto->path) }}"
                                         alt="Foto kerusakan"
                                         class="w-full h-36 object-cover group-hover:scale-105 transition duration-300">

                                </a>
                            @endforeach

                        </div>
                    @else
                        <p class="text-sm text-gray-400 mb-6">
                            Belum ada foto kerusakan.
                        </p>
                    @endif

                    <div class="border-t border-gray-100 pt-6">

                        <h3 class="font-semibold text-gray-700 mb-4">
                            Foto Hasil Perbaikan
                        </h3>

                        @if($fotoHasil->count())
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                                @foreach($fotoHasil as $foto)
                                    <a href="{{ asset('storage/' . $foto->path) }}"
                                       target="_blank"
                                       class="group rounded-xl overflow-hidden border border-gray-200">

                                        <img src="{{ asset('storage/' . $foto->path) }}"
                                             alt="Foto hasil perbaikan"
                                             class="w-full h-36 object-cover group-hover:scale-105 transition duration-300">

                                    </a>
                                @endforeach

                            </div>
                        @else
                            <p class="text-sm text-gray-400">
                                Belum ada dokumentasi hasil perbaikan.
                            </p>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- SIDEBAR INFORMASI --}}
        <div class="space-y-6">

            {{-- PELAPOR --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">

                <h2 class="font-bold text-lg text-gray-900 mb-5">
                    Informasi Pelapor
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="text-xs text-gray-400">Nama</p>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $laporan->pelapor->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="font-semibold text-gray-800 mt-1 break-all">
                            {{ $laporan->pelapor->email ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400">Unit / Bagian</p>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $laporan->pelapor->unit->nama_unit ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400">WhatsApp</p>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $laporan->pelapor->whatsapp ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- TEKNISI --}}
            @if($laporan->penugasan->isNotEmpty())
                @php
                    $penugasanAktif = $laporan->penugasan->sortByDesc('created_at')->first();
                @endphp

                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">

                    <h2 class="font-bold text-lg text-gray-900 mb-5">
                        Teknisi Penanggung Jawab
                    </h2>

                    <div class="flex items-center gap-3">

                        <div class="w-12 h-12 rounded-full bg-blue-50 text-primary flex items-center justify-center">
                            <i class="fas fa-user-hard-hat text-xl"></i>
                        </div>

                        <div>
                            <p class="font-bold text-gray-800">
                                {{ $penugasanAktif->teknisi->name ?? '-' }}
                            </p>

                            <p class="text-xs text-gray-500">
                                Teknisi UPA
                            </p>
                        </div>

                    </div>

                    @if($penugasanAktif->catatan_tugas)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400">
                                Catatan Penugasan
                            </p>

                            <p class="text-sm text-gray-700 mt-2">
                                {{ $penugasanAktif->catatan_tugas }}
                            </p>
                        </div>
                    @endif

                </div>
            @endif

            {{-- RIWAYAT STATUS --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">

                <h2 class="font-bold text-lg text-gray-900 mb-6">
                    Riwayat Status
                </h2>

                @if($laporan->riwayat->isNotEmpty())

                    <div class="relative space-y-6">

                        @foreach($laporan->riwayat->sortByDesc('created_at') as $riwayat)

                            <div class="relative pl-7">

                                <div class="absolute left-0 top-1 w-3 h-3 rounded-full bg-primary ring-4 ring-blue-50"></div>

                                @if(!$loop->last)
                                    <div class="absolute left-[5px] top-5 bottom-[-24px] w-0.5 bg-gray-200"></div>
                                @endif

                                <p class="font-semibold text-gray-800 text-sm">
                                    {{ ucfirst(str_replace('_', ' ', $riwayat->status_baru)) }}
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $riwayat->created_at->format('d M Y, H:i') }}
                                </p>

                                @if($riwayat->keterangan)
                                    <p class="text-sm text-gray-600 mt-2">
                                        {{ $riwayat->keterangan }}
                                    </p>
                                @endif

                                @if($riwayat->pengguna)
                                    <p class="text-xs text-gray-400 mt-1">
                                        Oleh: {{ $riwayat->pengguna->name }}
                                    </p>
                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <p class="text-sm text-gray-400">
                        Belum ada riwayat perubahan status.
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection
