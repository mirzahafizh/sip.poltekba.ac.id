@extends('layouts.app')
@section('body')
<div class="min-h-screen flex">
    @include('partials.sidebar-wadir')
    <div class="flex-1 min-w-0">
        <header class="bg-white border-b px-6 py-4 flex justify-between items-center">
            <div><p class="text-xs text-slate-500">Sistem Informasi UPA</p><h1 class="font-bold">Wadir Panel</h1></div>
            <div class="flex items-center gap-4 text-sm">
                <span>{{ auth()->user()->name ?? 'Pengguna' }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-red-600 font-semibold">Keluar</button></form>
            </div>
        </header>
        <main class="p-5 md:p-8 max-w-7xl mx-auto">@yield('content')</main>
    </div>
</div>
@endsection
