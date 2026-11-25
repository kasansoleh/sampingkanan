@extends('layouts.app')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Kontak (Pelanggan & Vendor)</h2>
        <a href="{{ route('contacts.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">+ Tambah Kontak</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Nama</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tipe</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Email</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Telepon</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($contacts as $c)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $c->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full font-medium {{ $c->type == 'customer' ? 'bg-blue-100 text-blue-800' : ($c->type == 'vendor' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800') }}">
                            {{ ucfirst($c->type) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $c->email ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $c->phone ?? '-' }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('contacts.edit', $c->id) }}" class="text-amber-600 hover:underline">Edit</a>
                        <form action="{{ route('contacts.destroy', $c->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus kontak ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada kontak.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $contacts->links() }}</div>
</div>
@endsection
