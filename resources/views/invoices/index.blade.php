@extends('layouts.app')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Faktur Penjualan</h2>
        <a href="{{ route('invoices.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">+ Buat Faktur Baru</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">No Faktur</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Pelanggan</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Jatuh Tempo</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Total</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($invoices as $inv)
                <tr>
                    <td class="px-4 py-3 font-medium text-emerald-600"><a href="{{ route('invoices.show', $inv->id) }}">{{ $inv->invoice_number }}</a></td>
                    <td class="px-4 py-3 text-gray-900">{{ $inv->contact->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $inv->date }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $inv->due_date }}</td>
                    <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $inv->status == 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ ucfirst($inv->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('invoices.show', $inv->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('invoices.edit', $inv->id) }}" class="text-amber-600 hover:underline">Edit</a>
                        <form action="{{ route('invoices.destroy', $inv->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus faktur ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada faktur penjualan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $invoices->links() }}</div>
</div>
@endsection
