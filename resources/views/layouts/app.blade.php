<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E‑Surat - @yield('title','Dashboard')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="h-full text-gray-900">
    <nav class="bg-white border-b">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-14 items-center gap-6">
                <a href="{{ route('surat-masuk.index') }}" class="font-semibold text-gray-800 hover:text-blue-700">Surat Masuk</a>
                <a href="{{ route('surat-keluar.index') }}" class="text-gray-600 hover:text-blue-700">Surat Keluar</a>
                <a href="{{ route('disposisi.index') }}" class="text-gray-600 hover:text-blue-700">Disposisi</a>
                <div class="ml-auto flex items-center gap-3">
                    @auth
                        <span class="text-sm text-gray-700">Masuk sebagai <b>{{ auth()->user()->name }}</b></span>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="text-sm text-red-600 hover:text-red-700">Logout</button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700">Login</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
        @if(session('success'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 px-4 py-2 text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-2 text-red-800">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
