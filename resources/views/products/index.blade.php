@extends('layouts.app')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Produk & Persediaan</h2>
        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">+ Tambah Produk</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">SKU</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Nama Produk</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Harga Beli</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Harga Jual</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Keuntungan (Profit)</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-500">Stok</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $p)
                @php
                    $profit = $p->sell_price - $p->buy_price;
                    $margin = $p->sell_price > 0 ? ($profit / $p->sell_price) * 100 : 0;
                @endphp
                <tr>
                    <td class="px-4 py-3 font-mono text-gray-600">{{ $p->sku }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $p->name }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($p->buy_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right font-semibold text-emerald-600">Rp {{ number_format($p->sell_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right">
                        <span class="font-medium text-blue-600">Rp {{ number_format($profit, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-500 block">({{ number_format($margin, 1) }}%)</span>
                    </td>
                    <td class="px-4 py-3 text-center"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $p->stock > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $p->stock }} {{ $p->unit }}</span></td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('products.edit', $p->id) }}" class="text-amber-600 hover:underline">Edit</a>
                        <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
