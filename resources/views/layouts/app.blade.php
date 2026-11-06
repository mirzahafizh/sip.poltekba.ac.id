
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @hasSection('title')
            @yield('title') | UPA Perawatan dan Perbaikan
        @else
            UPA Perawatan dan Perbaikan
        @endif
    </title>

    <meta name="description"
          content="Sistem Informasi Pelaporan Kerusakan dan Layanan Perawatan dan Perbaikan Politeknik Negeri Balikpapan.">

    <meta name="theme-color" content="#013880">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    {{-- Tailwind Configuration --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#013880',
                        secondary: '#0B5CAD',
                        accent: '#E8F1FC',
                        surface: '#F8FAFC'
                    },

                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        };
    </script>

    {{-- Global CSS --}}
    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }

        .brand,
        .brand-bg {
            background-color: #013880;
        }

        .brand-text {
            color: #013880;
        }

        /* SIDEBAR LINK */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .sidebar-link:hover {
            background: #e8f1fc;
            color: #013880;
        }

        .sidebar-link.active {
            background: #013880;
            color: white;
            box-shadow: 0 4px 10px rgba(1, 56, 128, .15);
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
        }

        /* SIDEBAR ANIMATION */
        .mobile-menu {
            transition: transform .25s ease, opacity .25s ease;
        }

        /* MOBILE SIDEBAR */
        @media (max-width: 767px) {
            .mobile-menu.hidden-menu {
                transform: translateX(-100%);
                opacity: 0;
                pointer-events: none;
                visibility: hidden;
            }

            .mobile-menu:not(.hidden-menu) {
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
            }
        }

        /* DESKTOP SIDEBAR */
        @media (min-width: 768px) {
            .mobile-menu {
                transform: translateX(0) !important;
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
            }
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen text-slate-800 antialiased">

    @auth

        <div class="min-h-screen flex">

            {{-- ========================================= --}}
            {{-- MOBILE OVERLAY --}}
            {{-- ========================================= --}}
            <div id="sidebarOverlay"
                 class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden"
                 onclick="closeSidebar()">
            </div>


            {{-- ========================================= --}}
            {{-- SIDEBAR --}}
            {{-- ========================================= --}}
            <aside id="sidebar"
                   class="mobile-menu hidden-menu fixed md:sticky md:top-0 top-0 left-0 z-50 h-screen w-72 md:w-64 bg-white border-r border-slate-200 flex flex-col shrink-0">

                {{-- LOGO --}}
                <div class="px-6 py-6 border-b border-slate-100">

                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-xl brand text-white flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-screwdriver-wrench text-xl"></i>
                        </div>

                        <div>
                            <h1 class="font-extrabold brand-text text-lg">
                                UPA
                            </h1>

                            <p class="text-xs text-slate-500">
                                Perawatan & Perbaikan
                            </p>
                        </div>

                    </a>

                </div>


                {{-- ========================================= --}}
                {{-- NAVIGATION --}}
                {{-- ========================================= --}}
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                    <p class="px-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-3">
                        Menu Utama
                    </p>


                    {{-- ================================= --}}
                    {{-- PELAPOR --}}
                    {{-- ================================= --}}
                    @if(auth()->user()->role === 'pelapor')

                        <a href="{{ route('pelapor.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('pelapor.dashboard') ? 'active' : '' }}">

                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard

                        </a>

                        <a href="{{ route('pelapor.laporan.create') }}"
                           class="sidebar-link {{ request()->routeIs('pelapor.laporan.create') ? 'active' : '' }}">

                            <i class="fa-solid fa-circle-plus"></i>
                            Buat Laporan

                        </a>

                    @endif


                    {{-- ================================= --}}
                    {{-- UPA --}}
                    {{-- ================================= --}}
                    @if(auth()->user()->role === 'upa')

                        <a href="{{ route('upa.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('upa.dashboard') ? 'active' : '' }}">

                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard

                        </a>

                        <a href="{{ route('upa.laporan.index') }}"
                           class="sidebar-link {{ request()->routeIs('upa.laporan.*') ? 'active' : '' }}">

                            <i class="fa-solid fa-clipboard-list"></i>
                            Data Laporan

                        </a>

                    @endif


                    {{-- ================================= --}}
                    {{-- WADIR II --}}
                    {{-- ================================= --}}
                    @if(auth()->user()->role === 'wadir_ii')

                        <a href="{{ route('wadir.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('wadir.dashboard') ? 'active' : '' }}">

                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard

                        </a>

                        <a href="{{ route('wadir.laporan.index') }}"
                           class="sidebar-link {{ request()->routeIs('wadir.laporan.*') ? 'active' : '' }}">

                            <i class="fa-solid fa-file-circle-check"></i>
                            Persetujuan Laporan

                        </a>

                    @endif


                    {{-- ================================= --}}
                    {{-- TEKNISI --}}
                    {{-- ================================= --}}
                    @if(auth()->user()->role === 'teknisi')

                        <a href="{{ route('teknisi.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('teknisi.dashboard') ? 'active' : '' }}">

                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard

                        </a>

                        <a href="{{ route('teknisi.tugas.index') }}"
                           class="sidebar-link {{ request()->routeIs('teknisi.tugas.*') ? 'active' : '' }}">

                            <i class="fa-solid fa-clipboard-list"></i>
                            Data Tugas

                        </a>

                    @endif


                    {{-- ================================= --}}
                    {{-- ADMIN --}}
                    {{-- ================================= --}}
                    @if(auth()->user()->role === 'admin')

                        <a href="{{ route('admin.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                            <i class="fa-solid fa-chart-pie"></i>
                            Dashboard

                        </a>

                        <p class="px-4 pt-5 pb-2 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                            Manajemen Data
                        </p>

                        <a href="{{ route('admin.users.index') }}"
                           class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

                            <i class="fa-solid fa-users"></i>
                            Pengguna

                        </a>

                        <a href="{{ route('admin.gedungs.index') }}"
                           class="sidebar-link {{ request()->routeIs('admin.gedungs.*') ? 'active' : '' }}">

                            <i class="fa-solid fa-building"></i>
                            Gedung

                        </a>

                        <a href="{{ route('admin.kategori-kerusakan.index') }}"
                           class="sidebar-link {{ request()->routeIs('admin.kategori-kerusakan.*') ? 'active' : '' }}">

                            <i class="fa-solid fa-list"></i>
                            Kategori Kerusakan

                        </a>

                        <a href="{{ route('admin.units.index') }}"
                           class="sidebar-link {{ request()->routeIs('admin.units.*') ? 'active' : '' }}">

                            <i class="fa-solid fa-sitemap"></i>
                            Unit

                        </a>

                    @endif


                    {{-- ================================= --}}
                    {{-- KEMBALI KE BERANDA --}}
                    {{-- ================================= --}}
                    <div class="pt-5 mt-5 border-t border-slate-100">

                        <a href="{{ route('landing') }}"
                           class="sidebar-link">

                            <i class="fa-solid fa-house"></i>
                            Halaman Beranda

                        </a>

                    </div>

                </nav>


                {{-- ========================================= --}}
                {{-- SIDEBAR FOOTER --}}
                {{-- ========================================= --}}
                <div class="px-5 py-5 border-t border-slate-100">

                    <p class="text-xs text-slate-400 text-center">
                        UPA Perawatan & Perbaikan
                    </p>

                    <p class="text-xs text-slate-400 text-center mt-1">
                        Politeknik Negeri Balikpapan
                    </p>

                    <p class="text-[10px] text-slate-300 text-center mt-2">
                        Sistem Informasi Layanan
                    </p>

                </div>

            </aside>


            {{-- ========================================= --}}
            {{-- MAIN AREA --}}
            {{-- ========================================= --}}
            <div class="flex-1 min-w-0 flex flex-col min-h-screen">


                {{-- ================================= --}}
                {{-- TOPBAR --}}
                {{-- ================================= --}}
                <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-5 md:px-8 sticky top-0 z-30">

                    <div class="flex items-center gap-3">

                        {{-- MOBILE MENU BUTTON --}}
                        <button type="button"
                                onclick="toggleSidebar()"
                                class="md:hidden w-10 h-10 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition"
                                aria-label="Buka menu"
                                aria-controls="sidebar"
                                aria-expanded="false"
                                id="sidebarToggle">

                            <i class="fa-solid fa-bars"></i>

                        </button>

                        <div>

                            <h2 class="font-bold text-slate-800 text-base md:text-lg">
                                @yield('page-title', 'Dashboard')
                            </h2>

                            <p class="text-[11px] md:text-xs text-slate-500 mt-1">
                                Sistem Informasi Perawatan dan Perbaikan
                            </p>

                        </div>

                    </div>


                    {{-- USER INFORMATION --}}
                    <div class="flex items-center gap-3">

                        <div class="hidden sm:block text-right">

                            <p class="text-sm font-bold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-slate-500 capitalize">
                                {{ str_replace('_', ' ', auth()->user()->role) }}
                            </p>

                        </div>

                        <div class="w-10 h-10 rounded-full bg-accent text-primary flex items-center justify-center font-bold shrink-0">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                        {{-- LOGOUT --}}
                        <form action="{{ route('logout') }}" method="POST">

                            @csrf

                            <button type="submit"
                                    class="text-red-500 hover:bg-red-50 w-10 h-10 rounded-xl transition"
                                    title="Keluar"
                                    aria-label="Keluar">

                                <i class="fa-solid fa-right-from-bracket"></i>

                            </button>

                        </form>

                    </div>

                </header>


                {{-- ========================================= --}}
                {{-- PAGE CONTENT --}}
                {{-- ========================================= --}}
                <main class="flex-1 p-5 md:p-8">


                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))

                        <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl">

                            <i class="fa-solid fa-circle-check mt-0.5"></i>

                            <div class="text-sm font-medium">
                                {{ session('success') }}
                            </div>

                        </div>

                    @endif


                    {{-- ERROR MESSAGE --}}
                    @if(session('error'))

                        <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">

                            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>

                            <div class="text-sm font-medium">
                                {{ session('error') }}
                            </div>

                        </div>

                    @endif


                    {{-- WARNING MESSAGE --}}
                    @if(session('warning'))

                        <div class="mb-6 flex items-start gap-3 bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-4 rounded-xl">

                            <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>

                            <div class="text-sm font-medium">
                                {{ session('warning') }}
                            </div>

                        </div>

                    @endif


                    {{-- VALIDATION ERRORS --}}
                    @if($errors->any())

                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">

                            <div class="flex items-center gap-2 font-bold mb-2">

                                <i class="fa-solid fa-circle-exclamation"></i>
                                Terdapat kesalahan:

                            </div>

                            <ul class="list-disc list-inside text-sm space-y-1">

                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- CONTENT FROM CHILD VIEW --}}
                    @yield('content')

                </main>


                {{-- ========================================= --}}
                {{-- MAIN FOOTER --}}
                {{-- ========================================= --}}
                <footer class="px-5 md:px-8 py-4 border-t border-slate-200 bg-white">

                    <p class="text-xs text-slate-400 text-center md:text-left">

                        &copy; {{ date('Y') }} UPA Perawatan dan Perbaikan
                        - Politeknik Negeri Balikpapan.
                        Seluruh hak cipta dilindungi.

                    </p>

                </footer>

            </div>

        </div>


    @else

        {{-- PUBLIC / AUTH PAGE --}}
        @yield('body')

    @endauth


    {{-- ========================================= --}}
    {{-- GLOBAL JAVASCRIPT --}}
    {{-- ========================================= --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');

            if (!sidebar || !overlay) {
                return;
            }

            const isOpening = sidebar.classList.contains('hidden-menu');

            sidebar.classList.toggle('hidden-menu', !isOpening);
            overlay.classList.toggle('hidden', !isOpening);

            document.body.classList.toggle('overflow-hidden', isOpening);

            if (toggle) {
                toggle.setAttribute('aria-expanded', isOpening ? 'true' : 'false');
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');

            if (!sidebar || !overlay) {
                return;
            }

            sidebar.classList.add('hidden-menu');
            overlay.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');

            if (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
            }
        }

        // Menutup sidebar setelah navigasi pada layar mobile.
        document.querySelectorAll('#sidebar a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });

        // Reset sidebar ketika ukuran layar berubah ke desktop.
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const toggle = document.getElementById('sidebarToggle');

                sidebar?.classList.remove('hidden-menu');
                overlay?.classList.add('hidden');

                document.body.classList.remove('overflow-hidden');

                toggle?.setAttribute('aria-expanded', 'false');
            } else {
                const sidebar = document.getElementById('sidebar');

                if (sidebar) {
                    sidebar.classList.add('hidden-menu');
                }
            }
        });
    </script>

    @stack('scripts')

</body>
</html>
