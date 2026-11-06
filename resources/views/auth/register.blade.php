@extends('layouts.auth')
@section('title','Daftar Akun')
@section('content')
<a href="{{ route('landing') }}" class="text-sm brand-text font-semibold">← Kembali ke beranda</a>
<h1 class="text-3xl font-bold mt-8">Buat akun pelapor</h1><p class="text-slate-500 mt-2">Lengkapi data untuk mulai menggunakan layanan.</p>
@if($errors->any())<div class="bg-red-50 text-red-700 p-3 rounded-lg mt-5">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('register.process') }}" class="space-y-4 mt-7">@csrf
@foreach([['name','Nama lengkap','text'],['email','Email','email'],['whatsapp','Nomor WhatsApp','text']] as $f)
<div><label class="text-sm font-semibold">{{ $f[1] }}</label><input type="{{ $f[2] }}" name="{{ $f[0] }}" value="{{ old($f[0]) }}" required class="mt-2 w-full border rounded-xl px-4 py-3"></div>
@endforeach
<div><label class="text-sm font-semibold">Unit / Bagian</label><select name="unit_id" required class="mt-2 w-full border rounded-xl px-4 py-3"><option value="">Pilih unit</option>@foreach(($units ?? []) as $unit)<option value="{{ $unit->id }}" @selected(old('unit_id')==$unit->id)>{{ $unit->nama_unit }}</option>@endforeach</select></div>
<div><label class="text-sm font-semibold">Password</label><input type="password" name="password" required class="mt-2 w-full border rounded-xl px-4 py-3"></div>
<div><label class="text-sm font-semibold">Konfirmasi password</label><input type="password" name="password_confirmation" required class="mt-2 w-full border rounded-xl px-4 py-3"></div>
<button class="brand text-white w-full rounded-xl py-3 font-bold">Daftar</button></form>
<p class="text-sm text-slate-500 mt-6 text-center">Sudah punya akun? <a href="{{ route('login') }}" class="brand-text font-bold">Login</a></p>
@endsection
