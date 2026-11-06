@extends('layouts.auth')
@section('title','Login')
@section('content')
<a href="{{ route('landing') }}" class="text-sm brand-text font-semibold">← Kembali ke beranda</a>
<h1 class="text-3xl font-bold mt-8">Selamat datang</h1><p class="text-slate-500 mt-2">Masuk ke akun layanan UPA Perawatan.</p>
@if(session('success'))<div class="bg-green-50 text-green-700 p-3 rounded-lg mt-5">{{ session('success') }}</div>@endif
@if($errors->any())<div class="bg-red-50 text-red-700 p-3 rounded-lg mt-5">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('login.process') }}" class="space-y-5 mt-7">@csrf
<div><label class="text-sm font-semibold">Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full border rounded-xl px-4 py-3"></div>
<div><label class="text-sm font-semibold">Password</label><input type="password" name="password" required class="mt-2 w-full border rounded-xl px-4 py-3"></div>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
<button class="brand text-white w-full rounded-xl py-3 font-bold">Login</button></form>
<p class="text-sm text-slate-500 mt-6 text-center">Belum punya akun? <a href="{{ route('register') }}" class="brand-text font-bold">Daftar sekarang</a></p>
@endsection
