@extends('layouts.app')
@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Pengguna (User)</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola akses akun admin dan kasir/karyawan</p>
        </div>
        <a href="{{ route('users.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md transition">+ Tambah User</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-400 text-xs uppercase tracking-wider">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-400 text-xs uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-400 text-xs uppercase tracking-wider">Role / Hak Akses</th>
                    <th class="px-4 py-3 text-right font-semibold text-slate-400 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $u)
                <tr>
                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $u->name }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $u->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $u->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ strtoupper($u->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if($u->id !== auth()->id())
                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <a href="{{ route('users.password.edit', $u->id) }}" class="text-indigo-600 hover:underline font-medium text-xs mr-3">Ubah Password</a>
                            <button type="submit" class="text-red-600 hover:underline font-medium text-xs" onclick="return confirm('Hapus user ini?')">Hapus</button>
                        </form>
                        @else
                        <span class="text-xs text-slate-400 italic">Akun Anda</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
