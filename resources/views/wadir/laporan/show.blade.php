
@extends('layouts.app')

@section('title', 'Detail Laporan - Wadir II')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('wadir.dashboard') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-blue-700">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-900">
                Detail Laporan Kerusakan
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Periksa informasi laporan sebelum memberikan persetujuan.
            </p>
        </div>

        <span class="inline-flex w-fit items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">
            <i class="fas fa-clock mr-2"></i>
            {{ $laporan->status === 'menunggu_persetujuan_wadir_ii' ? 'Menunggu Persetujuan' : str_replace('_', ' ', ucfirst($laporan->status)) }}
        </span>
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

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Informasi laporan --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- Identitas laporan --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-file-alt mr-2 text-blue-700"></i>
                        Informasi Laporan
                    </h2>
                </div>

                <div class="space-y-5 p-5">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Nomor Tiket
                        </p>
                        <p class="mt-1 text-lg font-bold text-blue-700">
                            {{ $laporan->nomor_tiket }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Judul Laporan
                        </p>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $laporan->judul_laporan }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Gedung
                            </p>
                            <p class="mt-1 text-sm text-gray-800">
                                {{ $laporan->gedung->nama_gedung ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Kategori Kerusakan
                            </p>
                            <p class="mt-1 text-sm text-gray-800">
                                {{ $laporan->kategori->nama_kategori ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Lokasi Detail
                        </p>
                        <p class="mt-1 text-sm text-gray-800">
                            {{ $laporan->lokasi_detail }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Deskripsi Kerusakan
                        </p>
                        <div class="mt-2 rounded-lg bg-gray-50 p-4 text-sm leading-relaxed text-gray-700">
                            {!! nl2br(e($laporan->deskripsi)) !!}
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Tanggal Pelaporan
                        </p>
                        <p class="mt-1 text-sm text-gray-800">
                            {{ $laporan->created_at?->translatedFormat('d F Y, H:i') }} WIB
                        </p>
                    </div>

                </div>
            </div>

            {{-- Foto kerusakan --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-images mr-2 text-blue-700"></i>
                        Foto Kerusakan
                    </h2>
                </div>

                <div class="p-5">
                    @php
                        $fotoKerusakan = $laporan->fotos
                            ->where('jenis_foto', 'kerusakan');
                    @endphp

                    @if($fotoKerusakan->count())
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            @foreach($fotoKerusakan as $foto)
                                <a href="{{ asset('storage/' . $foto->path) }}"
                                   target="_blank"
                                   class="group overflow-hidden rounded-lg border border-gray-200">
                                    <img
                                        src="{{ asset('storage/' . $foto->path) }}"
                                        alt="Foto kerusakan"
                                        class="h-40 w-full object-cover transition duration-300 group-hover:scale-105"
                                    >
                                    <div class="bg-gray-50 px-3 py-2 text-center text-xs text-gray-500">
                                        Lihat foto
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-lg bg-gray-50 p-8 text-center">
                            <i class="fas fa-image text-3xl text-gray-300"></i>
                            <p class="mt-2 text-sm text-gray-500">
                                Tidak ada foto kerusakan yang dilampirkan.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Sidebar informasi pelapor dan keputusan --}}
        <div class="space-y-6">

            {{-- Informasi pelapor --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-user mr-2 text-blue-700"></i>
                        Informasi Pelapor
                    </h2>
                </div>

                <div class="space-y-4 p-5">
                    <div>
                        <p class="text-xs text-gray-500">Nama Pelapor</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $laporan->pelapor->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="mt-1 break-all text-sm text-gray-800">
                            {{ $laporan->pelapor->email ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">Unit / Bagian</p>
                        <p class="mt-1 text-sm text-gray-800">
                            {{ $laporan->pelapor->unit->nama_unit ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">WhatsApp</p>
                        <p class="mt-1 text-sm text-gray-800">
                            {{ $laporan->pelapor->whatsapp ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Keputusan persetujuan --}}
            @if($laporan->status === 'menunggu_persetujuan_wadir_ii')

                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-5 py-4">
                        <h2 class="font-bold text-gray-900">
                            <i class="fas fa-clipboard-check mr-2 text-blue-700"></i>
                            Keputusan Persetujuan
                        </h2>
                    </div>

                    <div class="space-y-4 p-5">

                        {{-- Form setujui --}}
                        <div>
                            <p class="mb-3 text-sm text-gray-600">
                                Jika laporan valid dan layak ditindaklanjuti, berikan persetujuan agar laporan diteruskan ke UPA.
                            </p>

                            <form action="{{ route('wadir.laporan.setujui', $laporan) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menyetujui laporan ini?')">
                                @csrf

                                <button type="submit"
                                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                                    <i class="fas fa-check-circle"></i>
                                    Setujui Laporan
                                </button>
                            </form>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <p class="mb-3 text-sm text-gray-600">
                                Jika laporan tidak dapat disetujui, berikan alasan penolakan yang jelas.
                            </p>

                            <form action="{{ route('wadir.laporan.tolak', $laporan) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menolak laporan ini?')">
                                @csrf

                                <label for="catatan_penolakan"
                                       class="mb-2 block text-sm font-semibold text-gray-700">
                                    Alasan Penolakan
                                </label>

                                <textarea
                                    name="catatan_penolakan"
                                    id="catatan_penolakan"
                                    rows="4"
                                    required
                                    minlength="5"
                                    maxlength="2000"
                                    placeholder="Tuliskan alasan laporan ditolak..."
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                >{{ old('catatan_penolakan') }}</textarea>

                                @error('catatan_penolakan')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                        class="mt-3 flex w-full items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-700">
                                    <i class="fas fa-times-circle"></i>
                                    Tolak Laporan
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            @else

                {{-- Status sudah diproses --}}
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="font-bold text-gray-900">
                        Keputusan Wadir II
                    </h2>

                    @if($laporan->status === 'ditolak')
                        <div class="mt-4 rounded-lg bg-red-50 p-4">
                            <p class="font-semibold text-red-700">
                                <i class="fas fa-times-circle mr-2"></i>
                                Laporan Ditolak
                            </p>

                            <p class="mt-2 text-sm leading-relaxed text-red-700">
                                {{ $laporan->catatan_penolakan ?? 'Tidak ada catatan penolakan.' }}
                            </p>
                        </div>
                    @else
                        <div class="mt-4 rounded-lg bg-green-50 p-4">
                            <p class="font-semibold text-green-700">
                                <i class="fas fa-check-circle mr-2"></i>
                                Laporan Telah Disetujui
                            </p>

                            <p class="mt-2 text-sm text-green-700">
                                Laporan telah melewati tahap persetujuan Wadir II.
                            </p>
                        </div>
                    @endif
                </div>

            @endif

        </div>
    </div>

    {{-- Riwayat status --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-bold text-gray-900">
                <i class="fas fa-history mr-2 text-blue-700"></i>
                Riwayat Status Laporan
            </h2>
        </div>

        <div class="p-5">
            @if($laporan->riwayat->count())
                <div class="space-y-5">
                    @foreach($laporan->riwayat->sortByDesc('created_at') as $riwayat)
                        <div class="flex gap-4">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                <i class="fas fa-history text-sm"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900">
                                    {{ ucwords(str_replace('_', ' ', $riwayat->status_baru)) }}
                                </p>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $riwayat->keterangan ?? 'Status laporan diperbarui.' }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $riwayat->pengguna->name ?? 'Sistem' }}
                                    &bull;
                                    {{ $riwayat->created_at?->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">
                    Belum ada riwayat status laporan.
                </p>
            @endif
        </div>
    </div>

</div>
@endsection
