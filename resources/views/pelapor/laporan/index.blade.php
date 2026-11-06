
@extends('layouts.app')

@section('title', 'UPA Perawatan dan Perbaikan | Politeknik Negeri Balikpapan')

@section('body')

{{-- NAVBAR --}}
<nav class="bg-white sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="h-20 flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center text-white">
                    <i class="fas fa-tools text-xl"></i>
                </div>

                <div>
                    <h1 class="text-lg font-extrabold text-primary leading-tight">
                        UPA
                    </h1>
                    <p class="text-xs text-gray-500">
                        Perawatan dan Perbaikan
                    </p>
                </div>
            </a>

            {{-- DESKTOP MENU --}}
            <div class="hidden lg:flex items-center gap-8">

                <a href="#beranda"
                   class="text-sm font-semibold text-gray-700 hover:text-primary transition">
                    Beranda
                </a>

                <a href="#tentang"
                   class="text-sm font-semibold text-gray-700 hover:text-primary transition">
                    Tentang Layanan
                </a>

                <a href="#alur"
                   class="text-sm font-semibold text-gray-700 hover:text-primary transition">
                    Alur Pelaporan
                </a>

                <a href="{{ route('cek-status') }}"
                   class="text-sm font-semibold text-gray-700 hover:text-primary transition">
                    Cek Status Tiket
                </a>

            </div>

            {{-- BUTTON --}}
            <div class="hidden lg:flex items-center gap-3">

                <a href="{{ route('login') }}"
                   class="px-5 py-2.5 text-primary font-bold text-sm hover:bg-blue-50 rounded-xl transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="px-5 py-2.5 bg-primary text-white font-bold text-sm rounded-xl hover:bg-secondary transition">
                    Daftar
                </a>

            </div>

            {{-- MOBILE BUTTON --}}
            <button id="menuButton"
                    class="lg:hidden w-10 h-10 text-primary text-xl">
                <i class="fas fa-bars"></i>
            </button>

        </div>

        {{-- MOBILE MENU --}}
        <div id="mobileMenu" class="hidden lg:hidden pb-5 border-t border-gray-100">

            <div class="flex flex-col gap-2 pt-4">

                <a href="#beranda" class="px-3 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 rounded-lg">
                    Beranda
                </a>

                <a href="#tentang" class="px-3 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 rounded-lg">
                    Tentang Layanan
                </a>

                <a href="#alur" class="px-3 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 rounded-lg">
                    Alur Pelaporan
                </a>

                <a href="{{ route('cek-status') }}" class="px-3 py-2.5 text-sm font-semibold text-gray-700 hover:bg-blue-50 rounded-lg">
                    Cek Status Tiket
                </a>

                <div class="grid grid-cols-2 gap-3 mt-3">

                    <a href="{{ route('login') }}"
                       class="text-center border border-primary text-primary py-3 rounded-xl font-bold text-sm">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="text-center bg-primary text-white py-3 rounded-xl font-bold text-sm">
                        Daftar
                    </a>

                </div>

            </div>

        </div>
    </div>
</nav>


{{-- HERO SECTION --}}
<section id="beranda" class="relative overflow-hidden bg-primary">

    <div class="absolute inset-0 opacity-10">
        <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full border-[50px] border-white"></div>
        <div class="absolute -left-20 -bottom-32 w-96 h-96 rounded-full border-[50px] border-white"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-20 lg:py-28 relative">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

            {{-- TEXT --}}
            <div class="text-white">

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold mb-7">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    Layanan Resmi Politeknik Negeri Balikpapan
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight">
                    Layanan
                    <span class="text-blue-300">Perawatan</span>
                    dan
                    <span class="text-blue-300">Perbaikan</span>
                    Fasilitas Kampus
                </h1>

                <p class="text-blue-100 leading-relaxed mt-7 text-base md:text-lg max-w-xl">
                    Sistem informasi pelaporan kerusakan fasilitas kampus
                    yang memudahkan sivitas akademika menyampaikan laporan,
                    memantau proses penanganan, dan memperoleh informasi
                    perkembangan perbaikan secara transparan.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 mt-9">

                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center gap-3 px-7 py-4 bg-white text-primary rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
                        <i class="fas fa-file-circle-plus"></i>
                        Buat Laporan
                    </a>

                    <a href="{{ route('cek-status') }}"
                       class="inline-flex items-center justify-center gap-3 px-7 py-4 border border-white/40 text-white rounded-xl font-bold hover:bg-white/10 transition">
                        <i class="fas fa-search"></i>
                        Cek Status Tiket
                    </a>

                </div>

                <div class="flex flex-wrap items-center gap-6 mt-10 text-blue-100 text-sm">

                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-300"></i>
                        Pelaporan Mudah
                    </div>

                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-300"></i>
                        Pemantauan Transparan
                    </div>

                </div>

            </div>

            {{-- VISUAL --}}
            <div class="relative">

                <div class="bg-white/10 border border-white/20 rounded-3xl p-5 md:p-7 backdrop-blur-sm">

                    <div class="bg-white rounded-2xl p-6 shadow-2xl">

                        <div class="flex items-center justify-between border-b border-gray-100 pb-5">

                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">
                                    Sistem Pelaporan
                                </p>

                                <h3 class="text-xl font-extrabold text-gray-900 mt-1">
                                    UPA Perawatan
                                </h3>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
                                <i class="fas fa-tools text-xl"></i>
                            </div>

                        </div>

                        <div class="mt-6 space-y-5">

                            <div class="flex items-center gap-4">

                                <div class="w-11 h-11 rounded-xl bg-blue-50 text-primary flex items-center justify-center shrink-0">
                                    <i class="fas fa-file-alt"></i>
                                </div>

                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 text-sm">
                                        Pengajuan Laporan
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Kerusakan fasilitas kampus
                                    </p>
                                </div>

                                <i class="fas fa-check-circle text-green-500"></i>

                            </div>

                            <div class="border-l-2 border-dashed border-blue-200 ml-5 h-5"></div>

                            <div class="flex items-center gap-4">

                                <div class="w-11 h-11 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-user-check"></i>
                                </div>

                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 text-sm">
                                        Persetujuan Wadir II
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Pemeriksaan laporan
                                    </p>
                                </div>

                                <i class="fas fa-clock text-yellow-500"></i>

                            </div>

                            <div class="border-l-2 border-dashed border-blue-200 ml-5 h-5"></div>

                            <div class="flex items-center gap-4">

                                <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-wrench"></i>
                                </div>

                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 text-sm">
                                        Penanganan UPA
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Penugasan dan perbaikan
                                    </p>
                                </div>

                                <i class="fas fa-hourglass-half text-purple-500"></i>

                            </div>

                            <div class="border-l-2 border-dashed border-blue-200 ml-5 h-5"></div>

                            <div class="flex items-center gap-4">

                                <div class="w-11 h-11 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                                    <i class="fas fa-check-double"></i>
                                </div>

                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 text-sm">
                                        Verifikasi dan Selesai
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Penyelesaian laporan
                                    </p>
                                </div>

                                <i class="fas fa-check-circle text-green-500"></i>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="absolute -bottom-6 -left-5 bg-white rounded-2xl shadow-xl px-5 py-4 hidden md:block">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shield-alt"></i>
                        </div>

                        <div>
                            <p class="text-sm font-extrabold text-gray-800">
                                Sistem Terintegrasi
                            </p>
                            <p class="text-xs text-gray-400">
                                Pelaporan dan pemantauan
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>


{{-- TENTANG LAYANAN --}}
<section id="tentang" class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-14">

            <span class="text-primary text-sm font-bold uppercase tracking-wider">
                Tentang Layanan
            </span>

            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-3">
                Mendukung Fasilitas Kampus yang Aman dan Terawat
            </h2>

            <p class="text-gray-500 mt-5 leading-relaxed">
                UPA Perawatan dan Perbaikan menyediakan layanan pengelolaan
                laporan kerusakan fasilitas kampus melalui proses yang
                terstruktur, terdokumentasi, dan dapat dipantau.
            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="p-7 rounded-2xl border border-gray-100 bg-gray-50 hover:shadow-lg transition">

                <div class="w-14 h-14 bg-blue-100 text-primary rounded-2xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-clipboard-list"></i>
                </div>

                <h3 class="font-bold text-xl text-gray-900">
                    Pelaporan Terstruktur
                </h3>

                <p class="text-gray-500 text-sm leading-relaxed mt-3">
                    Pengguna dapat melaporkan kerusakan dengan informasi
                    lokasi, kategori, deskripsi, dan dokumentasi foto.
                </p>

            </div>

            <div class="p-7 rounded-2xl border border-gray-100 bg-gray-50 hover:shadow-lg transition">

                <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-tasks"></i>
                </div>

                <h3 class="font-bold text-xl text-gray-900">
                    Proses Penanganan
                </h3>

                <p class="text-gray-500 text-sm leading-relaxed mt-3">
                    Laporan diproses melalui persetujuan, penugasan teknisi,
                    pelaksanaan perbaikan, hingga verifikasi hasil.
                </p>

            </div>

            <div class="p-7 rounded-2xl border border-gray-100 bg-gray-50 hover:shadow-lg transition">

                <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-chart-line"></i>
                </div>

                <h3 class="font-bold text-xl text-gray-900">
                    Pemantauan Status
                </h3>

                <p class="text-gray-500 text-sm leading-relaxed mt-3">
                    Setiap laporan memiliki nomor tiket untuk memudahkan
                    pemantauan perkembangan proses penanganan.
                </p>

            </div>

        </div>

    </div>

</section>


{{-- ALUR PELAPORAN --}}
<section id="alur" class="py-20 bg-gray-50">

    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-14">

            <span class="text-primary text-sm font-bold uppercase tracking-wider">
                Alur Pelaporan
            </span>

            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-3">
                Bagaimana Proses Laporan Berjalan?
            </h2>

            <p class="text-gray-500 mt-5 leading-relaxed">
                Ikuti tahapan berikut untuk menyampaikan dan memantau
                laporan kerusakan fasilitas kampus.
            </p>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @php
                $alur = [
                    [
                        'nomor' => '01',
                        'icon' => 'fa-file-circle-plus',
                        'judul' => 'Buat Laporan',
                        'deskripsi' => 'Pelapor mengisi formulir dan mengunggah foto kerusakan.'
                    ],
                    [
                        'nomor' => '02',
                        'icon' => 'fa-user-check',
                        'judul' => 'Persetujuan',
                        'deskripsi' => 'Wakil Direktur II memeriksa dan menyetujui laporan.'
                    ],
                    [
                        'nomor' => '03',
                        'icon' => 'fa-screwdriver-wrench',
                        'judul' => 'Penanganan',
                        'deskripsi' => 'UPA menugaskan teknisi untuk melakukan perbaikan.'
                    ],
                    [
                        'nomor' => '04',
                        'icon' => 'fa-circle-check',
                        'judul' => 'Verifikasi',
                        'deskripsi' => 'UPA memeriksa hasil pekerjaan hingga laporan selesai.'
                    ],
                ];
            @endphp

            @foreach($alur as $item)

                <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm relative">

                    <div class="flex items-center justify-between mb-7">

                        <span class="text-4xl font-extrabold text-blue-100">
                            {{ $item['nomor'] }}
                        </span>

                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-primary flex items-center justify-center text-xl">
                            <i class="fas {{ $item['icon'] }}"></i>
                        </div>

                    </div>

                    <h3 class="font-bold text-lg text-gray-900">
                        {{ $item['judul'] }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-3 leading-relaxed">
                        {{ $item['deskripsi'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>


{{-- CTA --}}
<section class="bg-primary py-16">

    <div class="max-w-5xl mx-auto px-5 text-center">

        <div class="w-16 h-16 rounded-2xl bg-white/10 text-white flex items-center justify-center text-3xl mx-auto mb-6">
            <i class="fas fa-headset"></i>
        </div>

        <h2 class="text-3xl md:text-4xl font-extrabold text-white">
            Ada Fasilitas Kampus yang Mengalami Kerusakan?
        </h2>

        <p class="text-blue-100 mt-5 max-w-2xl mx-auto leading-relaxed">
            Segera sampaikan laporan agar kerusakan dapat diperiksa
            dan ditangani sesuai prosedur yang berlaku.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">

            <a href="{{ route('register') }}"
               class="px-7 py-4 bg-white text-primary rounded-xl font-bold hover:bg-blue-50 transition">
                Daftar dan Buat Laporan
                <i class="fas fa-arrow-right ml-2"></i>
            </a>

            <a href="{{ route('cek-status') }}"
               class="px-7 py-4 border border-white/40 text-white rounded-xl font-bold hover:bg-white/10 transition">
                Cek Status Tiket
            </a>

        </div>

    </div>

</section>


{{-- FOOTER --}}
<footer class="bg-gray-950 text-white pt-14 pb-7">

    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 pb-10 border-b border-white/10">

            <div>

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center">
                        <i class="fas fa-tools text-xl"></i>
                    </div>

                    <div>
                        <h3 class="font-extrabold text-lg">
                            UPA
                        </h3>

                        <p class="text-xs text-gray-400">
                            Perawatan dan Perbaikan
                        </p>
                    </div>

                </div>

                <p class="text-sm text-gray-400 leading-relaxed">
                    Sistem informasi layanan perawatan dan perbaikan
                    fasilitas Politeknik Negeri Balikpapan.
                </p>

            </div>

            <div>

                <h3 class="font-bold mb-5">
                    Navigasi
                </h3>

                <div class="space-y-3 text-sm text-gray-400">

                    <p><a href="#beranda" class="hover:text-white">Beranda</a></p>
                    <p><a href="#tentang" class="hover:text-white">Tentang Layanan</a></p>
                    <p><a href="#alur" class="hover:text-white">Alur Pelaporan</a></p>
                    <p><a href="{{ route('cek-status') }}" class="hover:text-white">Cek Status Tiket</a></p>

                </div>

            </div>

            <div>

                <h3 class="font-bold mb-5">
                    Politeknik Negeri Balikpapan
                </h3>

                <p class="text-sm text-gray-400 leading-relaxed">
                    Jl. Soekarno Hatta KM. 8, Balikpapan Utara,
                    Kota Balikpapan, Kalimantan Timur.
                </p>

                <a href="https://poltekba.ac.id"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 mt-4 text-blue-300 text-sm hover:text-white">
                    Website Resmi Poltekba
                    <i class="fas fa-external-link-alt"></i>
                </a>

            </div>

        </div>

        <div class="pt-7 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} UPA Perawatan dan Perbaikan.
            Politeknik Negeri Balikpapan.
        </div>

    </div>

</footer>

@endsection

@push('scripts')
<script>
    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    menuButton.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');

        const icon = menuButton.querySelector('i');

        if (mobileMenu.classList.contains('hidden')) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    });
</script>
@endpush
