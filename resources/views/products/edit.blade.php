@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Produk</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">SKU / Kode Produk</label>
            <input type="text" name="sku" value="{{ $product->sku }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm font-mono">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" name="category" value="{{ $product->category }}" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga Beli (Rp)</label>
                <input type="number" name="buy_price" value="{{ $product->buy_price }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                <input type="number" name="sell_price" value="{{ $product->sell_price }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Satuan (Unit)</label>
                <input type="text" name="unit" value="{{ $product->unit }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
        </div>
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">Batal</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">Perbarui Produk</button>
        </div>
    </form>
</div>
@endsection
