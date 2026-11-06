@extends('layouts.admin')
@section('title','Data Kategori Kerusakan')
@section('content')
<div class="flex justify-between items-center gap-4"><div><h2 class="text-2xl font-bold">Data Kategori Kerusakan</h2><p class="text-slate-500 mt-1">Kelola data kategori kerusakan.</p></div><a href="{{ route('admin.kategori-kerusakan.create') }}" class="brand text-white px-5 py-3 rounded-xl font-semibold">+ Tambah Kategori Kerusakan</a></div>
@if(session('success'))<div class="bg-green-50 text-green-700 p-4 rounded-xl mt-5">{{ session('success') }}</div>@endif
<div class="bg-white border rounded-2xl overflow-x-auto mt-7"><table class="w-full text-sm text-left"><thead class="bg-slate-50"><tr><th class="p-4">No.</th><th class="p-4">Nama</th><th class="p-4">Informasi</th><th class="p-4">Aksi</th></tr></thead><tbody>
@forelse(($kategoris ?? collect()) as $item)
<tr class="border-t"><td class="p-4">{{ $loop->iteration }}</td><td class="p-4 font-semibold">{{ $item->nama_kategori }}</td><td class="p-4">{{ $item->email ?? $item->kode_gedung ?? $item->deskripsi ?? '-' }}</td><td class="p-4 flex gap-3"><a href="{{ route('admin.kategori-kerusakan.edit',$item) }}" class="brand-text font-bold">Edit</a><form method="POST" action="{{ route('admin.kategori-kerusakan.destroy',$item) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="text-red-600 font-bold">Hapus</button></form></td></tr>
@empty<tr><td colspan="4" class="p-8 text-center text-slate-400">Belum ada data.</td></tr>@endforelse</tbody></table></div>
<div class="mt-5">{{ $kategoris->links() ?? '' }}</div>
@endsection
