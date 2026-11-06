@extends('layouts.app')
@section('title','Cek Status Tiket')
@section('body')
@include('partials.navbar')
<main class="max-w-3xl mx-auto px-5 py-16">
<div class="bg-white border rounded-3xl shadow-sm p-7 md:p-10">
<p class="brand-text font-bold text-sm uppercase tracking-widest">Pelacakan laporan</p><h1 class="text-3xl font-bold mt-2">Cek Status Tiket</h1>
<p class="text-slate-500 mt-3">Masukkan nomor tiket untuk melihat perkembangan laporan Anda.</p>
@if(session('error'))<div class="mt-5 bg-red-50 text-red-700 p-4 rounded-xl">{{ session('error') }}</div>@endif
@if($errors->any())<div class="mt-5 bg-red-50 text-red-700 p-4 rounded-xl">{{ $errors->first() }}</div>@endif
<form action="{{ route('cek-status.search') }}" method="POST" class="mt-7">@csrf
<label class="block text-sm font-semibold mb-2">Nomor tiket</label><input name="nomor_tiket" value="{{ old('nomor_tiket') }}" required placeholder="Contoh: UPA-20261106-0001" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-200 outline-none">
<button class="brand text-white font-bold rounded-xl px-6 py-3 mt-4 w-full">Cari Status Tiket</button>
</form>
<p class="text-xs text-slate-400 mt-5">Jangan bagikan nomor tiket kepada pihak yang tidak berkepentingan. Disarankan menambahkan kode verifikasi privat pada fitur pelacakan publik.</p>
</div></main>
@include('partials.footer')
@endsection
