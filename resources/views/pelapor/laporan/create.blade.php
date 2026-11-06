
@extends('layouts.app')

@section('title', 'Buat Laporan Kerusakan')
@section('page-title', 'Buat Laporan')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('pelapor.dashboard') }}" class="hover:text-primary">
            Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-primary font-semibold">Buat Laporan</span>
    </div>

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">
            Formulir Laporan Kerusakan
        </h1>
        <p class="text-gray-500 mt-2">
            Lengkapi informasi kerusakan fasilitas kampus dengan benar.
        </p>
    </div>

    {{-- INFORMASI ALUR --}}
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 flex gap-4">
        <div class="w-11 h-11 rounded-xl bg-blue-100 text-primary flex items-center justify-center shrink-0">
            <i class="fas fa-info-circle text-xl"></i>
        </div>

        <div>
            <h3 class="font-bold text-primary">
                Informasi Pelaporan
            </h3>
            <p class="text-sm text-blue-800 mt-1 leading-relaxed">
                Laporan yang kamu kirim akan diperiksa dan menunggu persetujuan
                Wakil Direktur II. Setelah disetujui, laporan akan diteruskan
                kepada UPA untuk proses penanganan.
            </p>
        </div>
    </div>

    {{-- FORM --}}
    <form action="{{ route('pelapor.laporan.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf

        {{-- DATA PELAPOR --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-bold text-lg text-gray-900">
                    <i class="fas fa-user text-primary mr-2"></i>
                    Informasi Pelapor
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi ini diambil dari akun yang sedang digunakan.
                </p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Pelapor
                    </label>

                    <input type="text"
                           value="{{ auth()->user()->name }}"
                           readonly
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-600">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email"
                           value="{{ auth()->user()->email }}"
                           readonly
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-600">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Unit / Bagian
                    </label>

                    <input type="text"
                           value="{{ auth()->user()->unit->nama_unit ?? 'Belum ditentukan' }}"
                           readonly
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-600">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor WhatsApp
                    </label>

                    <input type="text"
                           value="{{ auth()->user()->whatsapp ?? '-' }}"
                           readonly
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-600">
                </div>

            </div>
        </div>

        {{-- DETAIL KERUSAKAN --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-bold text-lg text-gray-900">
                    <i class="fas fa-tools text-primary mr-2"></i>
                    Detail Kerusakan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Masukkan informasi fasilitas yang mengalami kerusakan.
                </p>
            </div>

            <div class="p-6 space-y-5">

                {{-- JUDUL --}}
                <div>
                    <label for="judul_laporan"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Laporan <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           id="judul_laporan"
                           name="judul_laporan"
                           value="{{ old('judul_laporan') }}"
                           placeholder="Contoh: AC Ruang Kelas Tidak Dingin"
                           required
                           maxlength="255"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-blue-100 outline-none">

                    @error('judul_laporan')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- GEDUNG --}}
                <div>
                    <label for="gedung_id"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Gedung <span class="text-red-500">*</span>
                    </label>

                    <select id="gedung_id"
                            name="gedung_id"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary outline-none">

                        <option value="">-- Pilih Gedung --</option>

                        @foreach($gedungs as $gedung)
                            <option value="{{ $gedung->id }}"
                                {{ old('gedung_id') == $gedung->id ? 'selected' : '' }}>
                                {{ $gedung->nama_gedung }}
                            </option>
                        @endforeach

                    </select>

                    @error('gedung_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- LOKASI DETAIL --}}
                <div>
                    <label for="lokasi_detail"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Lokasi Detail <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           id="lokasi_detail"
                           name="lokasi_detail"
                           value="{{ old('lokasi_detail') }}"
                           placeholder="Contoh: Lantai 2, Ruang 203, dekat pintu masuk"
                           required
                           maxlength="255"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary outline-none">

                    @error('lokasi_detail')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- KATEGORI --}}
                <div>
                    <label for="kategori_kerusakan_id"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori Kerusakan <span class="text-red-500">*</span>
                    </label>

                    <select id="kategori_kerusakan_id"
                            name="kategori_kerusakan_id"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary outline-none">

                        <option value="">-- Pilih Kategori --</option>

                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_kerusakan_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach

                    </select>

                    @error('kategori_kerusakan_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label for="deskripsi"
                           class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Kerusakan <span class="text-red-500">*</span>
                    </label>

                    <textarea id="deskripsi"
                              name="deskripsi"
                              rows="5"
                              required
                              placeholder="Jelaskan kondisi kerusakan, kapan mulai terjadi, dan informasi lain yang dapat membantu proses perbaikan..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary outline-none resize-y">{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- FOTO KERUSAKAN --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-bold text-lg text-gray-900">
                    <i class="fas fa-camera text-primary mr-2"></i>
                    Foto Kerusakan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Lampirkan foto sebagai bukti kondisi fasilitas.
                </p>
            </div>

            <div class="p-6">

                <label for="foto"
                       class="block border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center cursor-pointer hover:border-primary hover:bg-blue-50 transition">

                    <div class="w-14 h-14 bg-blue-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                    </div>

                    <p class="font-bold text-gray-700">
                        Klik untuk memilih foto
                    </p>

                    <p class="text-sm text-gray-400 mt-2">
                        JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB per foto.
                    </p>

                    <input type="file"
                           id="foto"
                           name="foto[]"
                           accept="image/jpeg,image/png,image/webp"
                           multiple
                           class="hidden">

                </label>

                <div id="preview-foto" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-5"></div>

                @error('foto')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror

                @error('foto.*')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror

            </div>
        </div>

        {{-- PERSETUJUAN --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">

            <div class="flex gap-3">
                <i class="fas fa-exclamation-triangle text-yellow-600 mt-1"></i>

                <div>
                    <h3 class="font-bold text-yellow-800">
                        Perhatian
                    </h3>

                    <p class="text-sm text-yellow-800 mt-1 leading-relaxed">
                        Pastikan data yang dimasukkan sudah benar.
                        Setelah laporan dikirim, laporan akan masuk ke proses
                        persetujuan Wakil Direktur II.
                    </p>
                </div>
            </div>

        </div>

        {{-- TOMBOL --}}
        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

            <a href="{{ route('pelapor.dashboard') }}"
               class="px-6 py-3 rounded-xl border border-gray-300 text-gray-600 font-semibold text-center hover:bg-gray-50 transition">
                Batal
            </a>

            <button type="submit"
                    class="px-6 py-3 rounded-xl bg-primary hover:bg-secondary text-white font-bold transition">
                <i class="fas fa-paper-plane mr-2"></i>
                Kirim Laporan
            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')
<script>
    const inputFoto = document.getElementById('foto');
    const previewFoto = document.getElementById('preview-foto');

    inputFoto.addEventListener('change', function () {
        previewFoto.innerHTML = '';

        Array.from(this.files).forEach((file) => {
            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                const container = document.createElement('div');
                container.className = 'relative rounded-xl overflow-hidden border border-gray-200';

                const image = document.createElement('img');
                image.src = event.target.result;
                image.className = 'w-full h-32 object-cover';

                container.appendChild(image);
                previewFoto.appendChild(container);
            };

            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
