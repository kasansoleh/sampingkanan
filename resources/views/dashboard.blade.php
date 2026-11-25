@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-900 via-slate-900 to-slate-800 rounded-2xl p-8 text-white shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center">
        <div class="space-y-2">
            <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 text-xs font-semibold rounded-full uppercase tracking-wider">Dashboard Utama</span>
            <h2 class="text-3xl font-extrabold tracking-tight">Selamat Datang di SAMPING KANAN</h2>
            <p class="text-slate-300 text-sm max-w-xl">Kelola penjualan, pembelian, inventori produk, dan pencatatan keuangan bisnis Anda dengan mudah dan akurat.</p>
        </div>
        <div class="mt-6 md:mt-0 flex flex-wrap gap-3">
            <a href="{{ route('invoices.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-md transition flex items-center space-x-2">
                <span>+ Buat Faktur</span>
            </a>
            <a href="{{ route('bills.create') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-sm font-semibold border border-slate-700 transition flex items-center space-x-2">
                <span>+ Catat Pembelian</span>
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Penjualan (Lunas)</p>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">Rp</div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
            <div class="mt-2 flex items-center text-xs text-emerald-600 font-medium">
                <span>Pendapatan bersih lunas</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Piutang Menunggu</p>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">⏳</div>
            </div>
            <p class="text-2xl font-black text-amber-600 mt-3">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</p>
            <div class="mt-2 flex items-center text-xs text-amber-600 font-medium">
                <span>Belum lunas / terkirim</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pelanggan</p>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">👥</div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">{{ $totalCustomers }}</p>
            <div class="mt-2 flex items-center text-xs text-blue-600 font-medium">
                <span>Pelanggan aktif</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Produk</p>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">📦</div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">{{ $totalProducts }}</p>
            <div class="mt-2 flex items-center text-xs text-indigo-600 font-medium">
                <span>Item di inventori</span>
            </div>
        </div>
    </div>

    <!-- Recent Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Invoices -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-bold text-slate-900">Faktur Penjualan Terbaru</h3>
                <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 text-left font-semibold text-slate-400 text-xs uppercase tracking-wider">No Faktur</th>
                            <th class="px-3 py-3 text-left font-semibold text-slate-400 text-xs uppercase tracking-wider">Pelanggan</th>
                            <th class="px-3 py-3 text-right font-semibold text-slate-400 text-xs uppercase tracking-wider">Total</th>
                            <th class="px-3 py-3 text-center font-semibold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentInvoices as $inv)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-3 py-3 font-semibold"><a href="{{ route('invoices.show', $inv->id) }}" class="text-indigo-600 hover:underline">{{ $inv->invoice_number }}</a></td>
                            <td class="px-3 py-3 text-slate-700">{{ $inv->contact->name ?? '-' }}</td>
                            <td class="px-3 py-3 text-right font-semibold text-slate-900">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-center">
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $inv->status == 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ ucfirst($inv->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-3 py-6 text-center text-slate-400 text-sm">Belum ada faktur penjualan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Bills -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-bold text-slate-900">Pembelian Terbaru</h3>
                <a href="{{ route('bills.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 text-left font-semibold text-slate-400 text-xs uppercase tracking-wider">No Pembelian</th>
                            <th class="px-3 py-3 text-left font-semibold text-slate-400 text-xs uppercase tracking-wider">Vendor</th>
                            <th class="px-3 py-3 text-right font-semibold text-slate-400 text-xs uppercase tracking-wider">Total</th>
                            <th class="px-3 py-3 text-center font-semibold text-slate-400 text-xs uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentBills as $bill)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-3 py-3 font-semibold"><a href="{{ route('bills.show', $bill->id) }}" class="text-indigo-600 hover:underline">{{ $bill->bill_number }}</a></td>
                            <td class="px-3 py-3 text-slate-700">{{ $bill->contact->name ?? '-' }}</td>
                            <td class="px-3 py-3 text-right font-semibold text-slate-900">Rp {{ number_format($bill->total, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-center">
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $bill->status == 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-indigo-100 text-indigo-800' }}">
                                    {{ ucfirst($bill->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-3 py-6 text-center text-slate-400 text-sm">Belum ada transaksi pembelian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
