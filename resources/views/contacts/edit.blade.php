@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Kontak</h2>
    <form action="{{ route('contacts.update', $contact->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Kontak</label>
            <input type="text" name="name" value="{{ $contact->name }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Tipe Kontak</label>
            <select name="type" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
                <option value="customer" {{ $contact->type == 'customer' ? 'selected' : '' }}>Pelanggan (Customer)</option>
                <option value="vendor" {{ $contact->type == 'vendor' ? 'selected' : '' }}>Pemasok (Vendor)</option>
                <option value="both" {{ $contact->type == 'both' ? 'selected' : '' }}>Keduanya (Both)</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ $contact->email }}" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Telepon</label>
            <input type="text" name="phone" value="{{ $contact->phone }}" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea name="address" rows="3" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">{{ $contact->address }}</textarea>
        </div>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('contacts.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">Batal</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">Perbarui Kontak</button>
        </div>
    </form>
</div>
@endsection
