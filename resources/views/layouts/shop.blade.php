<!DOCTYPE html>
<html lang="pt-BR" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conheça a UNITV e assista à apresentação da experiência na tela.">
    <meta name="theme-color" content="#09090b">
    <title>UNITV — Seu entretenimento, em uma nova experiência.</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black font-sans antialiased text-white">
    <header class="sticky top-0 z-50 border-b border-white/10 bg-black/80 backdrop-blur-xl">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 sm:px-10 lg:px-12">
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-[-0.08em] text-white" aria-label="UNITV, início">
                UNITV<span class="text-indigo-400">.</span>
            </a>

            <nav class="hidden items-center gap-9 md:flex" aria-label="Navegação principal">
                <a href="{{ route('home') }}" class="text-sm text-zinc-300 transition hover:text-white">Início</a>
                <a href="{{ route('home') }}#apresentacao" class="text-sm text-zinc-300 transition hover:text-white">Apresentação</a>
                <a href="{{ route('home') }}#sobre" class="text-sm text-zinc-300 transition hover:text-white">Sobre</a>
            </nav>

            <a href="{{ route('home') }}#apresentacao" class="rounded-full border border-white/20 px-5 py-2.5 text-xs font-semibold text-white transition hover:border-white/50 hover:bg-white/5 sm:text-sm">
                Conheça a UNITV
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="px-6 py-9 sm:px-10 lg:px-12">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 border-t border-white/10 pt-8 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('home') }}" class="text-lg font-bold tracking-[-0.08em] text-white" aria-label="UNITV, início">
                UNITV<span class="text-indigo-400">.</span>
            </a>
            <p class="text-xs text-zinc-500">&copy; {{ date('Y') }} UNITV. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
