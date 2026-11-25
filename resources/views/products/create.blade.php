@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h2>
    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="name" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">SKU / Kode Produk</label>
            <input type="text" name="sku" required value="PRD-{{ rand(1000,9999) }}" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm font-mono">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" name="category" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm" placeholder="Contoh: Elektronik, Jasa">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga Beli (Rp)</label>
                <input type="number" name="buy_price" required value="0" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                <input type="number" name="sell_price" required value="0" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Stok Awal</label>
                <input type="number" name="stock" required value="10" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Satuan (Unit)</label>
                <input type="text" name="unit" required value="pcs" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
            </div>
        </div>
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">Batal</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">Simpan Produk</button>
        </div>
    </form>
</div>
@endsection
