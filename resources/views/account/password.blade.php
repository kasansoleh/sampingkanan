@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <h2 class="text-xl font-bold text-slate-900">Ubah Password Akun</h2>
    <p class="text-sm text-slate-500 mt-1 mb-6">Perbarui password login Anda secara berkala.</p>
    @if($errors->any())<div class="mb-4 bg-red-50 text-red-700 p-3 rounded-xl text-sm">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('account.password.update') }}" class="space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium">Password Saat Ini</label><input type="password" name="current_password" required class="mt-1 w-full rounded-xl border border-slate-200 p-3"></div>
        <div><label class="block text-sm font-medium">Password Baru</label><input type="password" name="password" required minlength="8" class="mt-1 w-full rounded-xl border border-slate-200 p-3"></div>
        <div><label class="block text-sm font-medium">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" required minlength="8" class="mt-1 w-full rounded-xl border border-slate-200 p-3"></div>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold">Simpan Password</button>
    </form>
</div>
@endsection
