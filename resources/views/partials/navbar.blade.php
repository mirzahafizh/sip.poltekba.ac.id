<header class="bg-white border-b border-slate-200 sticky top-0 z-40">
<nav class="max-w-7xl mx-auto px-5 h-18 min-h-[72px] flex items-center justify-between gap-4">
    <a href="{{ route('landing') }}" class="flex items-center gap-3">
        <span class="w-11 h-11 brand text-white rounded-xl grid place-items-center"><i class="fa-solid fa-screwdriver-wrench"></i></span>
        <span><b class="block brand-text leading-tight">UPA PERAWATAN</b><small class="text-slate-500">Politeknik Negeri Balikpapan</small></span>
    </a>
    <div class="hidden md:flex items-center gap-7 text-sm font-medium">
        <a href="{{ route('landing') }}" class="hover:brand-text">Beranda</a>
        <a href="{{ route('landing') }}#tentang" class="hover:brand-text">Tentang Layanan</a>
        <a href="{{ route('landing') }}#alur" class="hover:brand-text">Alur Pelaporan</a>
        <a href="{{ route('cek-status') }}" class="hover:brand-text">Cek Status Tiket</a>
    </div>
    <div class="flex items-center gap-2">
        @auth
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg brand text-white text-sm font-semibold">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-semibold brand-text">Login</a>
            <a href="{{ route('register') }}" class="hidden sm:inline-flex px-4 py-2 rounded-lg brand text-white text-sm font-semibold">Daftar</a>
        @endauth
    </div>
</nav>
</header>
