@extends('layouts.app')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pembelian (Bills & Vendor)</h2>
        <a href="{{ route('bills.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">+ Catat Pembelian Baru</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">No Pembelian</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Vendor / Pemasok</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Jatuh Tempo</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Total</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bills as $bill)
                <tr>
                    <td class="px-4 py-3 font-medium text-emerald-600"><a href="{{ route('bills.show', $bill->id) }}">{{ $bill->bill_number }}</a></td>
                    <td class="px-4 py-3 text-gray-900">{{ $bill->contact->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $bill->date }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $bill->due_date }}</td>
                    <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($bill->total, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $bill->status == 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('bills.show', $bill->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('bills.edit', $bill->id) }}" class="text-amber-600 hover:underline">Edit</a>
                        <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus pembelian ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada transaksi pembelian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $bills->links() }}</div>
</div>
@endsection
