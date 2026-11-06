
@extends('layouts.app')

@section('title', 'Beranda')

@section('body')

@include('partials.navbar')

{{-- HERO SECTION --}}
<section class="brand relative overflow-hidden text-white">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute -top-24 -right-20 w-96 h-96 rounded-full border-[40px] border-white"></div>
        <div class="absolute -bottom-40 -left-20 w-96 h-96 rounded-full border-[40px] border-white"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-5 py-20 md:py-28">
        <div class="grid md:grid-cols-2 gap-12 items-center">

            {{-- Hero Content --}}
            <div>
                <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-4 py-2 rounded-full text-sm font-medium">
                    <i class="fa-solid fa-building"></i>
                    Layanan Fasilitas Kampus
                </span>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mt-6">
                    Laporkan Kerusakan,
                    <span class="text-blue-200">Pantau Perbaikannya.</span>
                </h1>

                <p class="text-blue-100 text-base md:text-lg mt-6 leading-relaxed max-w-xl">
                    Platform layanan digital UPA Perawatan dan Perbaikan untuk
                    mempermudah sivitas akademika melaporkan kerusakan fasilitas
                    kampus serta memantau proses penanganannya secara transparan.
                </p>

                <div class="flex flex-wrap gap-3 mt-8">

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-2 bg-white text-blue-900 px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
                            <i class="fa-solid fa-gauge-high"></i>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 bg-white text-blue-900 px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
                            <i class="fa-solid fa-plus"></i>
                            Buat Laporan
                        </a>
                    @endauth

                    <a href="{{ route('cek-status') }}"
                       class="inline-flex items-center gap-2 border border-white/50 px-6 py-3 rounded-xl font-bold hover:bg-white/10 transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Cek Status Tiket
                    </a>

                </div>

                <div class="flex flex-wrap items-center gap-5 mt-10 text-sm text-blue-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-blue-200"></i>
                        Pelaporan online
                    </div>

                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-blue-200"></i>
                        Nomor tiket otomatis
                    </div>

                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-blue-200"></i>
                        Pantau progres
                    </div>
                </div>
            </div>

            {{-- Hero Illustration --}}
            <div class="relative">
                <div class="absolute inset-0 bg-blue-400/20 blur-3xl rounded-full"></div>

                <div class="relative bg-white/10 border border-white/20 rounded-3xl p-5 md:p-8 backdrop-blur-md shadow-2xl">

                    <div class="flex items-center justify-between mb-7">
                        <div>
                            <p class="text-blue-100 text-sm">Sistem Layanan</p>
                            <h2 class="text-xl font-bold mt-1">
                                UPA Perawatan
                            </h2>
                        </div>

                        <div class="w-12 h-12 bg-white/15 rounded-2xl grid place-items-center">
                            <i class="fa-solid fa-screwdriver-wrench text-2xl"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5">
                            <div class="w-11 h-11 bg-white/15 rounded-xl grid place-items-center">
                                <i class="fa-solid fa-clipboard-list text-xl"></i>
                            </div>

                            <p class="font-bold mt-4">Pelaporan</p>
                            <p class="text-sm text-blue-100 mt-1">
                                Laporan kerusakan tercatat
                            </p>
                        </div>

                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5">
                            <div class="w-11 h-11 bg-white/15 rounded-xl grid place-items-center">
                                <i class="fa-solid fa-user-check text-xl"></i>
                            </div>

                            <p class="font-bold mt-4">Persetujuan</p>
                            <p class="text-sm text-blue-100 mt-1">
                                Verifikasi Wadir II
                            </p>
                        </div>

                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5">
                            <div class="w-11 h-11 bg-white/15 rounded-xl grid place-items-center">
                                <i class="fa-solid fa-tools text-xl"></i>
                            </div>

                            <p class="font-bold mt-4">Perbaikan</p>
                            <p class="text-sm text-blue-100 mt-1">
                                Ditangani teknisi UPA
                            </p>
                        </div>

                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5">
                            <div class="w-11 h-11 bg-white/15 rounded-xl grid place-items-center">
                                <i class="fa-solid fa-circle-check text-xl"></i>
                            </div>

                            <p class="font-bold mt-4">Selesai</p>
                            <p class="text-sm text-blue-100 mt-1">
                                Hasil pekerjaan diverifikasi
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 bg-white/10 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-11 h-11 bg-green-400/20 rounded-full grid place-items-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-green-200"></i>
                        </div>

                        <div>
                            <p class="font-semibold text-sm">
                                Layanan terintegrasi
                            </p>
                            <p class="text-xs text-blue-100 mt-1">
                                Proses pelaporan dan penanganan terdokumentasi.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


{{-- TENTANG LAYANAN --}}
<section id="tentang" class="max-w-7xl mx-auto px-5 py-20 md:py-24">

    <div class="grid md:grid-cols-2 gap-12 items-center">

        <div>
            <span class="brand-text font-bold uppercase tracking-widest text-sm">
                Tentang Layanan
            </span>

            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-4 leading-tight">
                Satu Pintu untuk Kebutuhan Perawatan Fasilitas Kampus
            </h2>

            <p class="text-slate-600 mt-5 leading-relaxed">
                UPA Perawatan dan Perbaikan menyediakan layanan pelaporan
                kerusakan fasilitas kampus secara digital. Sivitas akademika
                dapat menyampaikan laporan, mendapatkan nomor tiket, serta
                memantau perkembangan penanganan melalui satu platform.
            </p>

            <p class="text-slate-600 mt-4 leading-relaxed">
                Setiap laporan akan melalui proses persetujuan, penugasan
                teknisi, pelaksanaan perbaikan, dan verifikasi hasil pekerjaan
                agar penanganan dapat dilakukan secara terstruktur.
            </p>

            <a href="{{ route('cek-status') }}"
               class="inline-flex items-center gap-2 brand-bg text-white px-6 py-3 rounded-xl font-semibold mt-7 hover:opacity-90 transition">
                Lihat Status Laporan
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-7 md:p-9">

            <h3 class="text-xl font-bold text-slate-900">
                Keunggulan Layanan
            </h3>

            <div class="space-y-6 mt-7">

                @foreach([
                    [
                        'icon' => 'fa-laptop',
                        'judul' => 'Pelaporan Digital',
                        'deskripsi' => 'Laporan dapat disampaikan secara online tanpa harus datang langsung.'
                    ],
                    [
                        'icon' => 'fa-ticket',
                        'judul' => 'Nomor Tiket',
                        'deskripsi' => 'Setiap laporan memiliki nomor tiket sebagai identitas pelacakan.'
                    ],
                    [
                        'icon' => 'fa-chart-line',
                        'judul' => 'Pemantauan Progres',
                        'deskripsi' => 'Pelapor dapat mengetahui perkembangan penanganan laporan.'
                    ],
                    [
                        'icon' => 'fa-clipboard-check',
                        'judul' => 'Riwayat Penanganan',
                        'deskripsi' => 'Setiap perubahan status laporan tercatat dalam sistem.'
                    ]
                ] as $item)

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl brand-bg text-white grid place-items-center shrink-0">
                            <i class="fa-solid {{ $item['icon'] }} text-lg"></i>
                        </div>

                        <div>
                            <h4 class="font-bold text-slate-900">
                                {{ $item['judul'] }}
                            </h4>

                            <p class="text-sm text-slate-500 mt-1 leading-relaxed">
                                {{ $item['deskripsi'] }}
                            </p>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>

    </div>
</section>


{{-- ALUR PELAPORAN --}}
<section id="alur" class="bg-white border-y border-slate-100 py-20 md:py-24">

    <div class="max-w-7xl mx-auto px-5">

        <div class="text-center max-w-2xl mx-auto">
            <span class="brand-text font-bold uppercase tracking-widest text-sm">
                Prosedur Layanan
            </span>

            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3">
                Alur Pelaporan dan Penanganan
            </h2>

            <p class="text-slate-500 mt-4 leading-relaxed">
                Berikut tahapan yang dilalui setiap laporan kerusakan
                fasilitas kampus hingga proses penanganan selesai.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-12">

            @foreach([
                [
                    'nomor' => '01',
                    'icon' => 'fa-file-circle-plus',
                    'judul' => 'Buat Laporan',
                    'deskripsi' => 'Pelapor mengisi informasi kerusakan, lokasi, kategori, dan foto pendukung.'
                ],
                [
                    'nomor' => '02',
                    'icon' => 'fa-user-check',
                    'judul' => 'Persetujuan Wadir II',
                    'deskripsi' => 'Laporan diperiksa dan mendapatkan persetujuan dari Wakil Direktur II.'
                ],
                [
                    'nomor' => '03',
                    'icon' => 'fa-screwdriver-wrench',
                    'judul' => 'Penanganan UPA',
                    'deskripsi' => 'UPA menerima laporan dan menugaskan teknisi untuk melakukan perbaikan.'
                ],
                [
                    'nomor' => '04',
                    'icon' => 'fa-clipboard-check',
                    'judul' => 'Verifikasi Hasil',
                    'deskripsi' => 'UPA memeriksa hasil pekerjaan sebelum laporan dinyatakan selesai.'
                ]
            ] as $step)

                <div class="group bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <div class="flex items-center justify-between">
                        <span class="w-12 h-12 rounded-xl brand-bg text-white grid place-items-center font-bold">
                            {{ $step['nomor'] }}
                        </span>

                        <i class="fa-solid {{ $step['icon'] }} text-2xl text-slate-300 group-hover:brand-text transition"></i>
                    </div>

                    <h3 class="font-bold text-lg text-slate-900 mt-6">
                        {{ $step['judul'] }}
                    </h3>

                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        {{ $step['deskripsi'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>
</section>


{{-- CTA --}}
<section class="brand text-white py-16 md:py-20">

    <div class="max-w-5xl mx-auto px-5 text-center">

        <div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/20 grid place-items-center mx-auto">
            <i class="fa-solid fa-headset text-3xl"></i>
        </div>

        <h2 class="text-3xl md:text-4xl font-extrabold mt-6">
            Ada Fasilitas Kampus yang Rusak?
        </h2>

        <p class="text-blue-100 mt-4 max-w-2xl mx-auto leading-relaxed">
            Sampaikan laporan kerusakan melalui sistem layanan UPA
            Perawatan dan Perbaikan agar dapat segera ditindaklanjuti.
        </p>

        <div class="flex flex-wrap justify-center gap-3 mt-8">

            @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-white text-blue-900 px-7 py-3 rounded-xl font-bold hover:bg-blue-50 transition">
                    Buka Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="bg-white text-blue-900 px-7 py-3 rounded-xl font-bold hover:bg-blue-50 transition">
                    Mulai Buat Laporan
                </a>
            @endauth

            <a href="{{ route('cek-status') }}"
               class="border border-white/50 px-7 py-3 rounded-xl font-bold hover:bg-white/10 transition">
                Cek Status Tiket
            </a>

        </div>

    </div>
</section>


@include('partials.footer')

@endsection
