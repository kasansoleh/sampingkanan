@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Profil Perusahaan (Faktur & Cetak)</h2>
    <form action="{{ route('company.update') }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
            <input type="text" name="name" value="{{ $company->name }}" required class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ $company->email }}" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Telepon</label>
            <input type="text" name="phone" value="{{ $company->phone }}" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">NPWP</label>
            <input type="text" name="tax_number" value="{{ $company->tax_number }}" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
            <textarea name="address" rows="3" class="mt-1 block w-full rounded-lg border border-gray-300 p-2.5 text-sm">{{ $company->address }}</textarea>
        </div>
        <div class="flex justify-end space-x-3 pt-4">
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
