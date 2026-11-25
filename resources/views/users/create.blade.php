@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <h2 class="text-xl font-bold text-slate-900 mb-6">Tambah Pengguna Baru</h2>
    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Nama Karyawan/Kasir">
        </div>
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Email</label>
            <input type="email" name="email" required class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="kasir@sampingkanan.com">
        </div>
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Password</label>
            <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="••••••••">
        </div>
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Role / Hak Akses</label>
            <select name="role" class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="cashier">Kasir / Karyawan (Input Penjualan & Pembelian)</option>
                <option value="admin">Admin (Akses Penuh)</option>
            </select>
        </div>
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md transition">Simpan User</button>
        </div>
    </form>
</div>
@endsection
