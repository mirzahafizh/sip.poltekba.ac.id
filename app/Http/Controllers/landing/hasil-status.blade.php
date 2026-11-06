@extends('layouts.app')
@section('title','Hasil Cek Status')
@section('body')
@include('partials.navbar')
<main class="max-w-3xl mx-auto px-5 py-12">
<a href="{{ route('cek-status') }}" class="brand-text text-sm font-semibold">← Cari tiket lain</a>
<div class="bg-white border rounded-2xl p-7 mt-5">
<p class="text-sm text-slate-500">Nomor tiket</p><h1 class="text-2xl font-bold">{{ $laporan->nomor_tiket }}</h1>
<div class="mt-5"><span class="inline-block bg-blue-50 text-blue-900 px-4 py-2 rounded-full font-semibold">{{ str_replace('_',' ',ucfirst($laporan->status)) }}</span></div>
<div class="grid sm:grid-cols-2 gap-5 mt-7 text-sm"><div><p class="text-slate-400">Judul laporan</p><b>{{ $laporan->judul_laporan }}</b></div><div><p class="text-slate-400">Tanggal laporan</p><b>{{ $laporan->created_at->format('d/m/Y') }}</b></div><div><p class="text-slate-400">Gedung</p><b>{{ $laporan->gedung->nama_gedung ?? '-' }}</b></div><div><p class="text-slate-400">Lokasi</p><b>{{ $laporan->lokasi_detail }}</b></div></div>
<h2 class="font-bold mt-8 mb-4">Riwayat status</h2><div class="space-y-4">@forelse($laporan->riwayat as $item)<div class="border-l-2 border-blue-300 pl-4"><p class="font-semibold">{{ str_replace('_',' ',ucfirst($item->status_baru)) }}</p><p class="text-xs text-slate-500 mt-1">{{ $item->created_at->format('d/m/Y H:i') }}</p></div>@empty<p class="text-sm text-slate-400">Belum ada riwayat status.</p>@endforelse</div>
</div></main>
@include('partials.footer')
@endsection
