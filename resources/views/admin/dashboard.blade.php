@extends('layouts.admin')
@section('title','Dashboard Admin')
@section('content')
<h2 class="text-2xl font-bold">Dashboard Administrator</h2><p class="text-slate-500 mt-1">Kelola pengguna dan data master layanan.</p>
<div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4 mt-7">
@foreach([['Total Pengguna',$totalUsers ?? 0,'fa-users'],['Unit',$totalUnits ?? 0,'fa-building-user'],['Gedung',$totalGedungs ?? 0,'fa-building'],['Kategori',$totalKategoris ?? 0,'fa-list']] as $stat)
<div class="bg-white border rounded-2xl p-5"><i class="fa-solid {{ $stat[2] }} brand-text text-xl"></i><p class="text-sm text-slate-500 mt-3">{{ $stat[0] }}</p><p class="text-3xl font-bold mt-1">{{ $stat[1] }}</p></div>
@endforeach
</div>
<div class="grid md:grid-cols-2 gap-4 mt-8">@foreach([['Kelola Pengguna','admin.users.index'],['Kelola Unit','admin.units.index'],['Kelola Gedung','admin.gedungs.index'],['Kategori Kerusakan','admin.kategori-kerusakan.index']] as $link)
<a href="{{ route($link[1]) }}" class="bg-white border rounded-2xl p-5 hover:border-blue-300 font-bold">{{ $link[0] }} <i class="fa-solid fa-arrow-right float-right brand-text"></i></a>@endforeach</div>
@endsection
