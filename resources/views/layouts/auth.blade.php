@extends('layouts.app')
@section('body')
<div class="min-h-screen grid lg:grid-cols-2">
    <section class="hidden lg:flex brand text-white p-14 flex-col justify-between">
        <a href="{{ route('landing') }}" class="text-xl font-bold"><i class="fa-solid fa-screwdriver-wrench mr-2"></i>UPA PERAWATAN</a>
        <div>
            <p class="uppercase tracking-[.25em] text-blue-200 text-sm mb-4">Politeknik Negeri Balikpapan</p>
            <h1 class="text-4xl font-bold leading-tight">Layanan Perawatan dan Perbaikan Fasilitas Kampus</h1>
            <p class="text-blue-100 mt-5 max-w-lg">Sampaikan laporan kerusakan fasilitas kampus dan pantau proses penanganannya secara transparan.</p>
        </div>
        <p class="text-sm text-blue-200">© {{ date('Y') }} Politeknik Negeri Balikpapan</p>
    </section>
    <main class="flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <a href="{{ route('landing') }}" class="brand-text font-bold text-lg lg:hidden"><i class="fa-solid fa-screwdriver-wrench mr-2"></i>UPA PERAWATAN</a>
            @yield('content')
        </div>
    </main>
</div>
@endsection
