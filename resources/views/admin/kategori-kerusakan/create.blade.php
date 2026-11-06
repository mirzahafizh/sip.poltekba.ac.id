@extends('layouts.admin')
@section('title','Tambah Deskripsi')
@section('content')
<a href="{{ route('admin.kategori-kerusakan.index') }}" class="brand-text text-sm font-semibold">← Kembali</a><h2 class="text-2xl font-bold mt-4">Tambah Deskripsi</h2>
@if($errors->any())<div class="bg-red-50 text-red-700 p-4 rounded-xl mt-5">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('admin.kategori-kerusakan.store') }}" class="bg-white border rounded-2xl p-6 mt-6 max-w-2xl space-y-5">@csrf 
<div><label class="block text-sm font-semibold">Nama kategori</label><input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required class="mt-2 w-full border rounded-xl p-3"></div><div><label class="block text-sm font-semibold">Deskripsi</label><textarea name="deskripsi" rows="3" class="mt-2 w-full border rounded-xl p-3">{{ old('deskripsi') }}</textarea></div><label class="flex items-center gap-2"><input type="checkbox" name="aktif" value="1" @checked(old('aktif',$kategoriKerusakan->aktif ?? true))> Aktif</label>
<button class="brand text-white px-6 py-3 rounded-xl font-bold">Simpan</button></form>
@endsection
