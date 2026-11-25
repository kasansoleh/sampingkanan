@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <div class="flex justify-between items-start border-b pb-6 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tagihan Pembelian (Bill)</h2>
            <p class="text-sm font-mono text-emerald-600 mt-1">{{ $bill->bill_number }}</p>
        </div>
        <div class="text-right">
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $bill->status == 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                {{ ucfirst($bill->status) }}
            </span>
            <p class="text-sm text-gray-500 mt-2">Tanggal: {{ $bill->date }}</p>
            <p class="text-sm text-gray-500">Jatuh Tempo: {{ $bill->due_date }}</p>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Vendor / Pemasok:</h3>
        <p class="text-base font-bold text-gray-800">{{ $bill->contact->name ?? '-' }}</p>
        <p class="text-sm text-gray-600">{{ $bill->contact->address ?? '' }}</p>
        <p class="text-sm text-gray-600">{{ $bill->contact->phone ?? '' }}</p>
    </div>

    <div class="overflow-x-auto mb-6">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2.5 text-left font-medium text-gray-600">Produk</th>
                    <th class="px-4 py-2.5 text-center font-medium text-gray-600">Qty</th>
                    <th class="px-4 py-2.5 text-right font-medium text-gray-600">Harga Pembelian</th>
                    <th class="px-4 py-2.5 text-right font-medium text-gray-600">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($bill->items as $item)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $item->product->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center border-t pt-4">
        <div>
            @if($bill->notes)
            <p class="text-xs text-gray-500">Catatan:</p>
            <p class="text-sm text-gray-700">{{ $bill->notes }}</p>
            @endif
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Total Pembelian</p>
            <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($bill->total, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <a href="{{ route('bills.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">Kembali</a>
        <a href="{{ route('bills.edit', $bill->id) }}" class="px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-medium">Edit</a>
        <a href="{{ route('bills.pdf', $bill->id) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium">Download PDF F4</a>
    </div>
</div>
@endsection
