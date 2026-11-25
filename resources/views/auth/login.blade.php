<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAMPING KANAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-900 flex items-center justify-center h-screen">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl p-8 m-4">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-indigo-600 tracking-wider">SAMPING KANAN</h1>
            <p class="text-sm text-slate-500 mt-1">Silakan masuk ke akun Anda</p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3 text-red-700 rounded-r-lg text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Email</label>
                <input type="email" name="email" required value="{{ old('email') }}" class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="admin@sampingkanan.com">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-bold shadow-md transition">Masuk</button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-400">
            Default Admin: admin@sampingkanan.com / password
        </div>
    </div>
</body>
</html>
