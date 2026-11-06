
@extends('layouts.app')

@section('title', 'Detail Tugas Teknisi')

@section('content')

@php
    $statusLabels = [
        'ditugaskan' => 'Menunggu Pengerjaan',
        'sedang_dikerjakan' => 'Sedang Dikerjakan',
        'menunggu_verifikasi' => 'Menunggu Verifikasi UPA',
        'selesai' => 'Selesai',
    ];

    $statusColors = [
        'ditugaskan' => 'bg-yellow-100 text-yellow-700',
        'sedang_dikerjakan' => 'bg-blue-100 text-blue-700',
        'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
        'selesai' => 'bg-green-100 text-green-700',
    ];

    $fotoKerusakan = $laporan->fotos->where('jenis_foto', 'kerusakan');
    $fotoHasil = $laporan->fotos->where('jenis_foto', 'hasil_perbaikan');
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route('teknisi.dashboard') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-700">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Detail Tugas
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Nomor Tiket:
                    <span class="font-semibold text-blue-700">
                        {{ $laporan->nomor_tiket }}
                    </span>
                </p>
            </div>

            <span class="inline-flex w-fit rounded-full px-4 py-2 text-sm font-semibold {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-700' }}">
                {{ $statusLabels[$laporan->status] ?? $laporan->status }}
            </span>
        </div>
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

        {{-- Konten utama --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- Informasi kerusakan --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-file-alt mr-2 text-blue-700"></i>
                        Informasi Kerusakan
                    </h2>
                </div>

                <div class="space-y-5 p-5">

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Judul Laporan
                        </p>

                        <p class="mt-1 text-lg font-bold text-gray-900">
                            {{ $laporan->judul_laporan }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">
                                Gedung
                            </p>

                            <p class="mt-1 text-sm text-gray-800">
                                {{ $laporan->gedung->nama_gedung ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">
                                Kategori Kerusakan
                            </p>

                            <p class="mt-1 text-sm text-gray-800">
                                {{ $laporan->kategori->nama_kategori ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Lokasi Detail
                        </p>

                        <p class="mt-1 text-sm text-gray-800">
                            {{ $laporan->lokasi_detail }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Deskripsi Kerusakan
                        </p>

                        <div class="mt-2 rounded-lg bg-gray-50 p-4 text-sm leading-relaxed text-gray-700">
                            {!! nl2br(e($laporan->deskripsi)) !!}
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            Tanggal Pelaporan
                        </p>

                        <p class="mt-1 text-sm text-gray-800">
                            {{ $laporan->created_at?->translatedFormat('d F Y, H:i') }} WIB
                        </p>
                    </div>

                </div>
            </div>

            {{-- Foto kerusakan awal --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-images mr-2 text-blue-700"></i>
                        Foto Kerusakan Awal
                    </h2>
                </div>

                <div class="p-5">
                    @if($fotoKerusakan->count())
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            @foreach($fotoKerusakan as $foto)
                                <a href="{{ asset('storage/' . $foto->path) }}"
                                   target="_blank"
                                   class="group overflow-hidden rounded-lg border border-gray-200">
                                    <img
                                        src="{{ asset('storage/' . $foto->path) }}"
                                        alt="Foto kerusakan"
                                        class="h-40 w-full object-cover transition group-hover:scale-105"
                                    >

                                    <p class="bg-gray-50 px-3 py-2 text-center text-xs text-gray-500">
                                        Lihat Foto
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">
                            Tidak ada foto kerusakan.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Instruksi UPA --}}
            <div class="overflow-hidden rounded-xl border border-blue-200 bg-white shadow-sm">
                <div class="border-b border-blue-100 bg-blue-50 px-5 py-4">
                    <h2 class="font-bold text-blue-900">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        Instruksi Penugasan dari UPA
                    </h2>
                </div>

                <div class="p-5">
                    <p class="whitespace-pre-line text-sm leading-relaxed text-gray-700">
                        {{ $penugasan->catatan_tugas ?: 'Tidak ada instruksi khusus. Silakan lakukan pemeriksaan dan penanganan sesuai kondisi kerusakan.' }}
                    </p>
                </div>
            </div>

            {{-- Foto hasil perbaikan --}}
            @if($fotoHasil->count())
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-5 py-4">
                        <h2 class="font-bold text-gray-900">
                            <i class="fas fa-tools mr-2 text-green-700"></i>
                            Foto Hasil Perbaikan
                        </h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-5 sm:grid-cols-3">
                        @foreach($fotoHasil as $foto)
                            <a href="{{ asset('storage/' . $foto->path) }}"
                               target="_blank"
                               class="group overflow-hidden rounded-lg border border-gray-200">
                                <img
                                    src="{{ asset('storage/' . $foto->path) }}"
                                    alt="Hasil perbaikan"
                                    class="h-40 w-full object-cover transition group-hover:scale-105"
                                >

                                <p class="bg-gray-50 px-3 py-2 text-center text-xs text-gray-500">
                                    Lihat Foto
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Form mulai pengerjaan --}}
            @if($laporan->status === 'ditugaskan')
                <div class="rounded-xl border border-blue-200 bg-white p-5 shadow-sm">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-play-circle mr-2 text-blue-700"></i>
                        Mulai Pengerjaan
                    </h2>

                    <p class="mt-2 text-sm text-gray-600">
                        Tekan tombol berikut apabila Anda siap memulai pekerjaan perbaikan.
                    </p>

                    <form action="{{ route('teknisi.tugas.mulai', $laporan) }}"
                          method="POST"
                          class="mt-5"
                          onsubmit="return confirm('Apakah Anda siap memulai pengerjaan laporan ini?')">
                        @csrf

                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                            <i class="fas fa-play"></i>
                            Mulai Pengerjaan
                        </button>
                    </form>
                </div>
            @endif

            {{-- Form kirim hasil pekerjaan --}}
            @if($laporan->status === 'sedang_dikerjakan')
                <div class="overflow-hidden rounded-xl border border-green-200 bg-white shadow-sm">
                    <div class="border-b border-green-100 bg-green-50 px-5 py-4">
                        <h2 class="font-bold text-green-900">
                            <i class="fas fa-check-circle mr-2"></i>
                            Kirim Hasil Pekerjaan
                        </h2>
                    </div>

                    <div class="p-5">
                        <p class="mb-5 text-sm leading-relaxed text-gray-600">
                            Setelah pekerjaan perbaikan selesai, unggah foto kondisi terbaru
                            sebagai dokumentasi. Hasil pekerjaan akan dikirim kepada UPA
                            untuk diperiksa dan diverifikasi.
                        </p>

                        <form action="{{ route('teknisi.tugas.selesai', $laporan) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="space-y-5"
                              onsubmit="return confirm('Kirim hasil pekerjaan kepada UPA untuk diverifikasi?')">

                            @csrf

                            <div>
                                <label for="foto"
                                       class="mb-2 block text-sm font-semibold text-gray-700">
                                    Foto Hasil Perbaikan
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="file"
                                    name="foto[]"
                                    id="foto"
                                    accept="image/jpeg,image/png,image/webp"
                                    multiple
                                    required
                                    class="w-full rounded-lg border border-gray-300 p-3 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700"
                                >

                                <p class="mt-2 text-xs text-gray-500">
                                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 foto,
                                    masing-masing maksimal 5 MB.
                                </p>

                                @error('foto')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror

                                @error('foto.*')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror

                                <div id="preview-foto"
                                     class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                                </div>
                            </div>

                            <div>
                                <label for="catatan_hasil"
                                       class="mb-2 block text-sm font-semibold text-gray-700">
                                    Catatan Hasil Pekerjaan
                                </label>

                                <textarea
                                    name="catatan_hasil"
                                    id="catatan_hasil"
                                    rows="4"
                                    maxlength="2000"
                                    placeholder="Jelaskan tindakan perbaikan yang sudah dilakukan dan kondisi setelah perbaikan..."
                                    class="w-full rounded-lg border border-gray-300 px-3 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                >{{ old('catatan_hasil') }}</textarea>

                                @error('catatan_hasil')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-green-700 px-4 py-3 text-sm font-semibold text-white hover:bg-green-800">
                                <i class="fas fa-paper-plane"></i>
                                Kirim untuk Verifikasi UPA
                            </button>

                        </form>
                    </div>
                </div>
            @endif

            {{-- Status menunggu verifikasi --}}
            @if($laporan->status === 'menunggu_verifikasi')
                <div class="rounded-xl border border-orange-200 bg-orange-50 p-5">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-clock mt-1 text-xl text-orange-600"></i>

                        <div>
                            <h2 class="font-bold text-orange-900">
                                Menunggu Verifikasi UPA
                            </h2>

                            <p class="mt-2 text-sm leading-relaxed text-orange-800">
                                Hasil pekerjaan Anda sudah dikirim.
                                Silakan menunggu pemeriksaan dari Kepala UPA.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Status selesai --}}
            @if($laporan->status === 'selesai')
                <div class="rounded-xl border border-green-200 bg-green-50 p-5">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle mt-1 text-xl text-green-600"></i>

                        <div>
                            <h2 class="font-bold text-green-900">
                                Pekerjaan Telah Selesai
                            </h2>

                            <p class="mt-2 text-sm leading-relaxed text-green-800">
                                Hasil perbaikan telah diterima dan diverifikasi oleh UPA.
                                Terima kasih atas pekerjaan Anda.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        {{-- Sidebar informasi --}}
        <div class="space-y-6">

            {{-- Informasi penugasan --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h2 class="font-bold text-gray-900">
                        <i class="fas fa-user-cog mr-2 text-blue-700"></i>
                        Informasi Penugasan
                    </h2>
                </div>

                <div class="space-y-4 p-5">

                    <div>
                        <p class="text-xs text-gray-500">
                            Teknisi
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $penugasan->teknisi->name ?? auth()->user()->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">
                            Ditugaskan oleh
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $penugasan->pemberiTugas->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">
                            Tanggal Penugasan
                        </p>

                        <p class="mt-1 text-sm text-gray-800">
                            {{ $penugasan->tanggal_penugasan?->translatedFormat('d F Y, H:i') ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">
                            Mulai Pengerjaan
                        </p>

                        <p class="mt-1 text-sm text-gray-800">
                            {{ $penugasan->mulai_dikerjakan?->translatedFormat('d F Y, H:i') ?? 'Belum dimulai' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">
                            Pengiriman Hasil
                        </p>

                        <p class="mt-1 text-sm text-gray-800">
                            {{ $penugasan->selesai_dikerjakan?->translatedFormat('d F Y, H:i') ?? 'Belum dikirim' }}
                        </p>
                    </div>

                </div>
            </div>

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

        </div>

    </div>

</div>

{{-- Preview foto sebelum upload --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputFoto = document.getElementById('foto');
        const preview = document.getElementById('preview-foto');

        if (!inputFoto || !preview) return;

        inputFoto.addEventListener('change', function () {
            preview.innerHTML = '';

            const files = Array.from(this.files);

            if (files.length > 5) {
                alert('Maksimal 5 foto.');
                this.value = '';
                return;
            }

            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();

                reader.onload = function (event) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'overflow-hidden rounded-lg border border-gray-200';

                    const image = document.createElement('img');
                    image.src = event.target.result;
                    image.alt = 'Preview foto';
                    image.className = 'h-32 w-full object-cover';

                    const caption = document.createElement('p');
                    caption.className = 'truncate bg-gray-50 px-2 py-2 text-xs text-gray-600';
                    caption.textContent = file.name;

                    wrapper.appendChild(image);
                    wrapper.appendChild(caption);
                    preview.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });
        });
    });
</script>

@endsection
