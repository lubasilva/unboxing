<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Unboxing' }} - Abra. Descubra.</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white font-sans antialiased">
    
    <!-- Header -->
    <header class="border-b border-zinc-800/50 backdrop-blur-sm sticky top-0 z-50 bg-black/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tighter">
                    UNBOXING
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('shop.products.index') }}" class="text-zinc-400 hover:text-white transition">Produtos</a>
                    <a href="{{ route('shop.category', 'oculos') }}" class="text-zinc-400 hover:text-white transition">Óculos</a>
                    <a href="{{ route('shop.category', 'tenis') }}" class="text-zinc-400 hover:text-white transition">Tênis</a>
                    <a href="{{ route('shop.category', 'streetwear') }}" class="text-zinc-400 hover:text-white transition">Streetwear</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="text-zinc-400 hover:text-white transition relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-white text-black text-xs w-4 h-4 rounded-full flex items-center justify-center font-bold">0</span>
                    </a>
                    
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-zinc-400 hover:text-white transition text-sm">Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="text-zinc-400 hover:text-white transition text-sm">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-zinc-800/50 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">UNBOXING</h3>
                    <p class="text-zinc-400 text-sm">Abra. Descubra.</p>
                    <p class="text-zinc-500 text-sm mt-2">Estilo urbano premium.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Links</h4>
                    <ul class="space-y-2 text-sm text-zinc-400">
                        <li><a href="{{ route('shop.products.index') }}" class="hover:text-white transition">Produtos</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">Carrinho</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Contato</h4>
                    <ul class="space-y-2 text-sm text-zinc-400">
                        <li>Brasília, DF</li>
                        <li>contato@unboxing.com.br</li>
                        <li>(61) 99999-9999</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-zinc-800/50 mt-8 pt-8 text-center text-sm text-zinc-500">
                &copy; {{ date('Y') }} Unboxing. Todos os direitos reservados.
            </div>
        </div>
    </footer>
</body>
</html>
