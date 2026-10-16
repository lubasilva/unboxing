<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Unboxing</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-zinc-950 border-r border-zinc-800/50 overflow-y-auto">
            <div class="p-8">
                <h1 class="text-2xl font-bold tracking-tighter mb-8">UNBOXING</h1>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block px-4 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-800' : 'hover:bg-zinc-900' }} transition">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.finance.index') }}" 
                       class="block px-4 py-2 rounded {{ request()->routeIs('admin.finance.*') ? 'bg-zinc-800' : 'hover:bg-zinc-900' }} transition">
                        Financeiro
                    </a>
                    <a href="{{ route('admin.categorias.index') }}" 
                       class="block px-4 py-2 rounded {{ request()->routeIs('admin.categorias.*') ? 'bg-zinc-800' : 'hover:bg-zinc-900' }} transition">
                        Categorias
                    </a>
                    <a href="{{ route('admin.produtos.index') }}" 
                       class="block px-4 py-2 rounded {{ request()->routeIs('admin.produtos.*') ? 'bg-zinc-800' : 'hover:bg-zinc-900' }} transition">
                        Produtos
                    </a>
                    <a href="{{ route('admin.pedidos.index') }}" 
                       class="block px-4 py-2 rounded {{ request()->routeIs('admin.pedidos.*') ? 'bg-zinc-800' : 'hover:bg-zinc-900' }} transition">
                        Pedidos
                    </a>
                    <a href="{{ route('admin.settings.index') }}" 
                       class="block px-4 py-2 rounded {{ request()->routeIs('admin.settings.*') ? 'bg-zinc-800' : 'hover:bg-zinc-900' }} transition">
                        Configurações
                    </a>
                </nav>

                <hr class="border-zinc-800 my-8">

                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-zinc-500 hover:text-white transition">Sair</button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                <!-- Flash Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-950/20 border border-red-800/50 rounded text-red-400 text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-950/20 border border-green-800/50 rounded text-green-400 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-950/20 border border-red-800/50 rounded text-red-400 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Content -->
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
