@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <div class="flex justify-between items-start border-b pb-6 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ \App\Models\CompanyProfile::current()->name }}</h2>
            <p class="text-xs text-gray-500">{{ \App\Models\CompanyProfile::current()->address }}</p>
            <p class="text-xs text-gray-500">Telp: {{ \App\Models\CompanyProfile::current()->phone }}</p>
            <h3 class="text-lg font-bold text-emerald-600 mt-3">FAKTUR PENJUALAN</h3>
            <p class="text-sm font-mono text-gray-600">{{ $invoice->invoice_number }}</p>
        </div>
        <div class="text-right">
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $invoice->status == 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                {{ ucfirst($invoice->status) }}
            </span>
            <p class="text-sm text-gray-500 mt-2">Tanggal: {{ $invoice->date }}</p>
            <p class="text-sm text-gray-500">Jatuh Tempo: {{ $invoice->due_date }}</p>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Kepada Pelanggan:</h3>
        <p class="text-base font-bold text-gray-800">{{ $invoice->contact->name ?? '-' }}</p>
        <p class="text-sm text-gray-600">{{ $invoice->contact->address ?? '' }}</p>
        <p class="text-sm text-gray-600">{{ $invoice->contact->phone ?? '' }}</p>
    </div>

    <div class="overflow-x-auto mb-6">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2.5 text-left font-medium text-gray-600">Produk</th>
                    <th class="px-4 py-2.5 text-center font-medium text-gray-600">Qty</th>
                    <th class="px-4 py-2.5 text-right font-medium text-gray-600">Harga Jual</th>
                    <th class="px-4 py-2.5 text-right font-medium text-gray-600">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($invoice->items as $item)
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
            @if($invoice->notes)
            <p class="text-xs text-gray-500">Catatan:</p>
            <p class="text-sm text-gray-700">{{ $invoice->notes }}</p>
            @endif
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Total Tagihan</p>
            <p class="text-sm text-gray-500">Ongkos Kirim: Rp {{ number_format($invoice->shipping_cost ?? 0, 0, ',', '.') }}</p>
            <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($invoice->total, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">Kembali</a>
        <a href="{{ route('invoices.pdf', $invoice->id) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">📥 Download PDF (F4)</a>
        <button onclick="window.print()" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-900">Cetak</button>
    </div>
</div>
@endsection
