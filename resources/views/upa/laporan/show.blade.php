
@extends('layouts.app')

@section('title', 'Detail Laporan - UPA')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('upa.laporan.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-700">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Laporan
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-900">
                Detail Laporan Kerusakan
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Periksa laporan dan kelola proses penanganan kerusakan.
            </p>
        </div>

        @php
            $statusLabels = [
                'disetujui' => 'Disetujui',
                'menunggu_penanganan_upa' => 'Menunggu Penanganan UPA',
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
                'selesai' => 'bg-green-100 text-green-700',
            ];
        @endphp

        <span class="inline-flex w-fit items-center rounded-full px-4 py-2 text-sm font-semibold {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-700' }}">
            {{ $statusLabels[$laporan->status] ?? str_replace('_', ' ', ucfirst($laporan->status)) }}
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

    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Kolom utama --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- Informasi laporan --}}
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
                        <p class="mt-1 font-semibold text-gray-900">
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
                        Dokumentasi Kerusakan
                    </h2>
                </div>

                <div class="p-5">
                    @php
                        $fotoKerusakan = $laporan->fotos->where('jenis_foto', 'kerusakan');
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
                                Tidak ada foto kerusakan.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Dokumentasi hasil perbaikan --}}
            @php
                $fotoHasil = $laporan->fotos->where('jenis_foto', 'hasil_perbaikan');
            @endphp

            @if($fotoHasil->count())
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-5 py-4">
                        <h2 class="font-bold text-gray-900">
                            <i class="fas fa-tools mr-2 text-green-700"></i>
                            Dokumentasi Hasil Perbaikan
                        </h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-5 sm:grid-cols-3">
                        @foreach($fotoHasil as $foto)
                            <a href="{{ asset('storage/' . $foto->path) }}"
                               target="_blank"
                               class="group overflow-hidden rounded-lg border border-gray-200">
                                <img
                                    src="{{ asset('storage/' . $foto->path) }}"
                                    alt="Foto hasil perbaikan"
                                    class="h-40 w-full object-cover transition duration-300 group-hover:scale-105"
                                >
                                <div class="bg-gray-50 px-3 py-2 text-center text-xs text-gray-500">
                                    Lihat hasil
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Riwayat status --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-history mr-2 text-blue-700"></i>
                        Riwayat Status
                    </h2>
                </div>

                <div class="space-y-5 p-5">
                    @forelse($laporan->riwayat->sortByDesc('created_at') as $riwayat)
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
                    @empty
                        <p class="text-sm text-gray-500">
                            Belum ada riwayat status.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Sidebar kanan --}}
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
                        <p class="text-xs text-gray-500">Nama</p>
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

            {{-- Penugasan teknisi --}}
            @if(in_array($laporan->status, [
                'disetujui',
                'menunggu_penanganan_upa',
                'ditugaskan',
            ]))

                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-5 py-4">
                        <h2 class="font-bold text-gray-900">
                            <i class="fas fa-user-cog mr-2 text-blue-700"></i>
                            Penugasan Teknisi
                        </h2>
                    </div>

                    <div class="p-5">

                        @if($laporan->status === 'ditugaskan' && $laporan->penugasan)
                            <div class="mb-5 rounded-lg bg-blue-50 p-4">
                                <p class="text-xs font-semibold uppercase text-blue-600">
                                    Teknisi Saat Ini
                                </p>

                                <p class="mt-2 font-bold text-gray-900">
                                    {{ $laporan->penugasan->teknisi->name ?? '-' }}
                                </p>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $laporan->penugasan->teknisi->email ?? '-' }}
                                </p>

                                @if($laporan->penugasan->catatan_tugas)
                                    <p class="mt-3 text-sm text-gray-600">
                                        {{ $laporan->penugasan->catatan_tugas }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        <form action="{{ route('upa.laporan.tugaskan', $laporan) }}"
                              method="POST"
                              class="space-y-4"
                              onsubmit="return confirm('Apakah Anda yakin ingin menyimpan penugasan teknisi ini?')">

                            @csrf

                            <div>
                                <label for="teknisi_id"
                                       class="mb-2 block text-sm font-semibold text-gray-700">
                                    Pilih Teknisi
                                </label>

                                <select
                                    name="teknisi_id"
                                    id="teknisi_id"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                >
                                    <option value="">-- Pilih Teknisi --</option>

                                    @foreach($teknisis as $teknisi)
                                        <option value="{{ $teknisi->id }}"
                                            @selected(old('teknisi_id') == $teknisi->id)>
                                            {{ $teknisi->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('teknisi_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="catatan_tugas"
                                       class="mb-2 block text-sm font-semibold text-gray-700">
                                    Instruksi Penugasan
                                </label>

                                <textarea
                                    name="catatan_tugas"
                                    id="catatan_tugas"
                                    rows="4"
                                    maxlength="2000"
                                    placeholder="Tuliskan instruksi atau pekerjaan yang harus dilakukan teknisi..."
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                >{{ old('catatan_tugas', $laporan->penugasan->catatan_tugas ?? '') }}</textarea>

                                @error('catatan_tugas')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                                <i class="fas fa-user-check"></i>

                                {{ $laporan->penugasan ? 'Perbarui Penugasan' : 'Tugaskan Teknisi' }}
                            </button>

                        </form>
                    </div>
                </div>

            @endif

            {{-- Status pengerjaan --}}
            @if(in_array($laporan->status, [
                'sedang_dikerjakan',
                'menunggu_verifikasi',
                'selesai',
            ]))

                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-tools mr-2 text-blue-700"></i>
                        Status Penanganan
                    </h2>

                    <div class="mt-4 rounded-lg bg-blue-50 p-4">
                        <p class="text-sm font-semibold text-blue-800">
                            {{ $statusLabels[$laporan->status] ?? $laporan->status }}
                        </p>

                        <p class="mt-2 text-xs leading-relaxed text-blue-700">
                            @if($laporan->status === 'sedang_dikerjakan')
                                Teknisi sedang melakukan penanganan kerusakan.
                            @elseif($laporan->status === 'menunggu_verifikasi')
                                Teknisi telah mengirim hasil pekerjaan. Silakan periksa dan verifikasi.
                            @else
                                Laporan telah selesai diverifikasi.
                            @endif
                        </p>
                    </div>

                    @if($laporan->penugasan)
                        <div class="mt-4">
                            <p class="text-xs text-gray-500">Teknisi yang menangani</p>
                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $laporan->penugasan->teknisi->name ?? '-' }}
                            </p>
                        </div>
                    @endif
                </div>

            @endif

            {{-- Verifikasi hasil --}}
            @if($laporan->status === 'menunggu_verifikasi')

                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-5 py-4">
                        <h2 class="font-bold text-gray-900">
                            <i class="fas fa-clipboard-check mr-2 text-orange-600"></i>
                            Verifikasi Hasil Pekerjaan
                        </h2>
                    </div>

                    <div class="p-5">
                        <p class="mb-4 text-sm leading-relaxed text-gray-600">
                            Periksa hasil perbaikan dan dokumentasi dari teknisi. Pilih hasil verifikasi sesuai kondisi pekerjaan.
                        </p>

                        <form action="{{ route('upa.laporan.verifikasi', $laporan) }}"
                              method="POST"
                              class="space-y-4"
                              onsubmit="return confirm('Apakah Anda yakin dengan hasil verifikasi ini?')">

                            @csrf

                            <div>
                                <label for="hasil"
                                       class="mb-2 block text-sm font-semibold text-gray-700">
                                    Hasil Verifikasi
                                </label>

                                <select
                                    name="hasil"
                                    id="hasil"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                >
                                    <option value="">-- Pilih Hasil --</option>
                                    <option value="diterima" @selected(old('hasil') === 'diterima')>
                                        Terima - Pekerjaan Selesai
                                    </option>
                                    <option value="perlu_perbaikan" @selected(old('hasil') === 'perlu_perbaikan')>
                                        Perlu Perbaikan Ulang
                                    </option>
                                </select>

                                @error('hasil')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="catatan"
                                       class="mb-2 block text-sm font-semibold text-gray-700">
                                    Catatan Verifikasi
                                </label>

                                <textarea
                                    name="catatan"
                                    id="catatan"
                                    rows="4"
                                    maxlength="2000"
                                    placeholder="Tuliskan hasil pemeriksaan atau catatan perbaikan ulang..."
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                >{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-orange-600 px-4 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                                <i class="fas fa-check-double"></i>
                                Simpan Verifikasi
                            </button>

                        </form>
                    </div>
                </div>

            @endif

            {{-- Hasil verifikasi sebelumnya --}}
            @if($laporan->verifikasi)
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="font-bold text-gray-900">
                        Hasil Verifikasi
                    </h2>

                    <div class="mt-4 rounded-lg p-4 {{ $laporan->verifikasi->hasil === 'diterima' ? 'bg-green-50' : 'bg-orange-50' }}">
                        <p class="font-semibold {{ $laporan->verifikasi->hasil === 'diterima' ? 'text-green-700' : 'text-orange-700' }}">
                            {{ $laporan->verifikasi->hasil === 'diterima' ? 'Pekerjaan Diterima' : 'Perlu Perbaikan' }}
                        </p>

                        <p class="mt-2 text-sm text-gray-700">
                            {{ $laporan->verifikasi->catatan ?? 'Tidak ada catatan.' }}
                        </p>

                        <p class="mt-3 text-xs text-gray-500">
                            Diverifikasi oleh:
                            {{ $laporan->verifikasi->verifikator->name ?? '-' }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ $laporan->verifikasi->diverifikasi_pada?->format('d/m/Y H:i') ?? '-' }}
                        </p>
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection
