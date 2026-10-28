<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dior Boutique Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#060913] text-gray-100 font-sans antialiased flex items-center justify-center min-h-screen">
    
    <div class="w-full max-w-md p-8 bg-[#0a0f1d] border border-gray-800/80 rounded-2xl shadow-2xl">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold tracking-widest text-white">DIOR</h1>
            <p class="text-xs text-gray-400 tracking-widest mt-1">BOUTIQUE MANAGEMENT</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-950/50 border border-rose-800 text-rose-300 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs uppercase tracking-wider text-gray-400 mb-2 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 bg-[#060913] border border-gray-800 rounded-xl text-white focus:outline-none focus:border-indigo-600 transition">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-wider text-gray-400 mb-2 font-medium">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 bg-[#060913] border border-gray-800 rounded-xl text-white focus:outline-none focus:border-indigo-600 transition">
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition shadow-lg">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>