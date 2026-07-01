<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A community-owned archive of the Lunguda (Nʋngʋra) language and culture — dictionary, oral traditions, lineage, rulers and heritage of Jessu, Gombe State.">

    <title>{{ $title ?? 'Lunguda Heritage Archive' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    {{-- The global audio player store is registered in resources/js/app.js
         on alpine:init. Any element can call $store.audio.play(src, id). --}}

    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:left-4 focus:top-4 btn-ink">Skip to content</a>

    {{-- ===== Navigation ===== --}}
    <header
        x-data="{ open: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 8"
        class="sticky top-0 z-40 transition-colors duration-300"
        :class="scrolled ? 'bg-millet/85 backdrop-blur border-b border-basalt/5' : 'bg-transparent'"
    >
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 group">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-basalt text-millet font-display text-lg font-semibold group-hover:bg-sorghum transition-colors">Nʋ</span>
                <span class="leading-tight">
                    <span class="block font-display text-lg font-semibold">Lunguda</span>
                    <span class="block text-[11px] uppercase tracking-[.16em] text-basalt/55">Heritage Archive</span>
                </span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                @php $nav = [
                    ['dictionary','Dictionary'], ['oral-traditions','Oral Traditions'],
                    ['rulers','Rulers'], ['family-trees','Lineage'],
                    ['culture','Culture'], ['monuments','Sites'], ['about','About'],
                ]; @endphp
                @foreach ($nav as [$route, $label])
                    <a href="{{ route($route) }}" wire:navigate
                       @class([
                           'rounded-full px-3.5 py-2 text-sm font-semibold transition-colors hover:bg-basalt/5',
                           'text-sorghum-600' => request()->routeIs($route),
                           'text-basalt/75' => ! request()->routeIs($route),
                       ])>{{ $label }}</a>
                @endforeach
            </div>

            <div class="flex items-center gap-2">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" wire:navigate class="hidden btn-ghost sm:inline-flex">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button class="btn-ghost">Sign out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="hidden btn-ghost sm:inline-flex">Sign in</a>
                @endauth
                <button @click="open = !open" class="btn-ghost lg:hidden" aria-label="Menu">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path x-show="!open" d="M4 6h16M4 12h16M4 18h16"/><path x-show="open" d="M6 6l12 12M6 18L18 6"/></svg>
                </button>
            </div>
        </nav>

        <div x-show="open" x-collapse class="lg:hidden">
            <div class="mx-auto max-w-6xl px-4 pb-4 grid grid-cols-2 gap-2">
                @foreach ($nav as [$route, $label])
                    <a href="{{ route($route) }}" wire:navigate @click="open=false" class="rounded-xl bg-white/70 px-4 py-3 text-sm font-semibold">{{ $label }}</a>
                @endforeach
            </div>
        </div>
    </header>

    <main id="main">
        {{ $slot }}
    </main>

    {{-- ===== Footer ===== --}}
    <div class="ridge mt-20"></div>
    <footer class="bg-basalt text-millet/80">
        <div class="mx-auto max-w-6xl px-4 py-14 grid gap-10 md:grid-cols-3">
            <div>
                <p class="font-display text-xl text-millet">Lunguda Heritage Archive</p>
                <p class="mt-3 text-sm leading-relaxed text-millet/65">A community-owned record of the language, lineage and living culture of the Nʋngʋra people of Jessu, Balanga LGA, Gombe State.</p>
            </div>
            <div>
                <p class="eyebrow text-sorghum-400">Explore</p>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ route('dictionary') }}" wire:navigate class="hover:text-millet">Dictionary</a></li>
                    <li><a href="{{ route('oral-traditions') }}" wire:navigate class="hover:text-millet">Oral traditions</a></li>
                    <li><a href="{{ route('rulers') }}" wire:navigate class="hover:text-millet">Rulers & lineage</a></li>
                    <li><a href="{{ route('culture') }}" wire:navigate class="hover:text-millet">Culture & attire</a></li>
                </ul>
            </div>
            <div>
                <p class="eyebrow text-sorghum-400">Contribute</p>
                <p class="mt-3 text-sm leading-relaxed text-millet/65">Speakers and elders can add words, recordings and stories. Sign in or ask an administrator for an account.</p>
                @guest<a href="{{ route('register') }}" wire:navigate class="mt-3 inline-block btn-primary">Create an account</a>@endguest
            </div>
        </div>
        <div class="border-t border-millet/10">
            <div class="mx-auto max-w-6xl px-4 py-5 text-xs text-millet/50 flex flex-wrap items-center justify-between gap-2">
                <span>© {{ date('Y') }} Lunguda Heritage Archive. Heritage content belongs to the Lunguda community.</span>
                <span class="font-mono">Nʋngʋra · Niger-Congo · 5 dialects</span>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
