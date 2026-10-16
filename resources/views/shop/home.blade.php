@extends('layouts.shop')

@section('content')
<section class="relative isolate overflow-hidden border-b border-zinc-800/70">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,rgba(99,102,241,0.16),transparent_58%)]"></div>

    <div class="mx-auto grid min-h-[76vh] max-w-7xl items-center gap-12 px-6 py-24 sm:px-10 lg:grid-cols-[1.05fr_0.95fr] lg:px-12 lg:py-28">
        <div class="max-w-2xl">
            <p class="mb-6 inline-flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.3em] text-indigo-300">
                <span class="h-px w-8 bg-indigo-400"></span>
                UNITV
            </p>
            <h1 class="text-5xl font-semibold leading-[1.05] tracking-tight text-white sm:text-6xl lg:text-7xl">
                Seu entretenimento, em uma nova experiência.
            </h1>
            <p class="mt-7 max-w-xl text-lg leading-8 text-zinc-400 sm:text-xl">
                Conheça a UNITV e veja como é a experiência na tela.
            </p>
            <a href="#apresentacao" class="mt-10 inline-flex items-center gap-3 rounded-full bg-white px-7 py-4 text-sm font-semibold text-black transition hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2 focus:ring-offset-black">
                Assistir apresentação
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 0 1 1.414 0l5 5a1 1 0 0 1 0 1.414l-5 5a1 1 0 0 1-1.414-1.414L13.586 10H4a1 1 0 1 1 0-2h9.586l-3.293-3.293a1 1 0 0 1 0-1.414Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <div id="apresentacao" class="scroll-mt-24 mx-auto w-full max-w-2xl overflow-hidden rounded-3xl border border-white/10 bg-black shadow-2xl shadow-indigo-950/30">
            <video class="aspect-video w-full" controls playsinline preload="metadata" aria-label="Vídeo de apresentação da UNITV">
                <source src="{{ asset('media/unitv.mp4') }}" type="video/mp4">
                Seu navegador não conseguiu reproduzir este vídeo. Abra a apresentação em outro navegador.
            </video>
        </div>
    </div>
</section>

<section id="sobre" class="border-y border-zinc-800/70 bg-zinc-950/70 px-6 py-20 sm:px-10 lg:px-12">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.3em] text-indigo-300">UNITV</p>
            <h2 class="text-2xl font-semibold tracking-tight text-white sm:text-3xl">Descubra a experiência por você mesmo.</h2>
        </div>
        <a href="#apresentacao" class="inline-flex w-fit items-center gap-2 rounded-full border border-white/20 px-6 py-3 text-sm font-medium text-white transition hover:border-white/50 hover:bg-white/5">
            Ver apresentação
            <span aria-hidden="true">↗</span>
        </a>
    </div>
</section>
@endsection
