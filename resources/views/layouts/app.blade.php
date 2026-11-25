<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAMPING KANAN - Sistem Akuntansi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-slate-900 text-white shadow-xl">
                <div class="flex items-center justify-center h-20 bg-slate-900 border-b border-slate-800 px-4 text-center">
                    <div>
                        <div class="text-lg font-extrabold tracking-widest text-indigo-400">SAMPING KANAN</div>
                        <div class="text-[10px] text-slate-400 tracking-wider mt-0.5">Sistem Akuntansi & POS</div>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                        📊 Beranda
                    </a>
                    <a href="{{ route('invoices.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition {{ request()->routeIs('invoices.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                        💰 Penjualan / Faktur
                    </a>
                    <a href="{{ route('bills.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition {{ request()->routeIs('bills.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                        🛒 Pembelian / Bill
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="pt-4 pb-1">
                        <p class="px-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Admin Menu</p>
                    </div>
                    <a href="{{ route('contacts.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition {{ request()->routeIs('contacts.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                        👥 Kontak Pelanggan/Vendor
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                        📦 Produk & Inventori
                    </a>
                    <a href="{{ route('company.edit') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition {{ request()->routeIs('company.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                        ⚙️ Profil Perusahaan
                    </a>
                    <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition {{ request()->routeIs('users.*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                        👤 Manajemen User
                    </a>
                    @endif
                </div>

                <!-- User Profile & Logout -->
                <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                    <div class="flex items-center justify-between mb-3">
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-[10px] text-indigo-400 uppercase font-semibold">{{ auth()->user()->role ?? '' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('account.password.edit') }}" class="block w-full mb-2 py-2 text-center bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-bold">Ubah Password</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-xl text-xs font-bold transition text-center">
                            Keluar (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-y-auto">
            <header class="flex items-center justify-between h-20 bg-white border-b border-slate-100 px-8 shadow-sm">
                <div>
                    <h1 class="text-lg font-bold text-slate-800">Sistem Akuntansi & Manajemen</h1>
                    <p class="text-xs text-slate-400">PT Maju Jaya / {{ \App\Models\CompanyProfile::current()->name }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        {{ strtoupper(auth()->user()->role ?? 'GUEST') }}: {{ auth()->user()->name ?? '' }}
                    </span>
                </div>
            </header>
            <main class="flex-1 p-8 bg-slate-50">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 rounded-r-xl shadow-sm text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 rounded-r-xl shadow-sm text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
