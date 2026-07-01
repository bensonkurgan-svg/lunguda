<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} · Lunguda Archive</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-millet">
    <div x-data="{ sidebar: false }" class="min-h-screen lg:flex">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-basalt text-millet/80 transition-transform lg:static lg:translate-x-0"
               :class="sidebar && 'translate-x-0'">
            <div class="flex h-16 items-center gap-3 px-5">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-sorghum text-white font-display font-semibold">Nʋ</span>
                <span class="font-display text-lg text-millet">Admin</span>
            </div>
            <nav class="mt-2 space-y-1 px-3 text-sm">
                @php $items = [
                    ['admin.dashboard','Dashboard','M4 6h16M4 12h16M4 18h7'],
                    ['admin.words','Words','M3 7h18M3 12h18M3 17h12'],
                    ['admin.rulers','Rulers','M5 16l-2-9 5 4 4-7 4 7 5-4-2 9z'],
                    ['admin.culture','Culture & attire','M3 16l5-5 4 4 3-3 6 6M3 8h18'],
                    ['admin.moderation','Moderation','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ]; @endphp
                @foreach ($items as [$route,$label,$path])
                    <a href="{{ route($route) }}" wire:navigate
                       @class([
                           'flex items-center gap-3 rounded-xl px-3 py-2.5 transition',
                           'bg-millet/10 text-millet' => request()->routeIs($route),
                           'hover:bg-millet/5' => ! request()->routeIs($route),
                       ])>
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
            <div class="absolute inset-x-0 bottom-0 border-t border-millet/10 p-4 text-xs">
                <p class="text-millet/55">Signed in as</p>
                <p class="font-semibold text-millet">{{ auth()->user()->name }}</p>
                <p class="text-millet/45 capitalize">{{ auth()->user()->role }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('home') }}" wire:navigate class="flex-1 rounded-lg bg-millet/10 px-3 py-2 text-center hover:bg-millet/15">View site</a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">@csrf
                        <button class="w-full rounded-lg bg-millet/10 px-3 py-2 hover:bg-millet/15">Sign out</button>
                    </form>
                </div>
            </div>
        </aside>

        <div x-show="sidebar" @click="sidebar=false" class="fixed inset-0 z-30 bg-basalt/50 lg:hidden" style="display:none"></div>

        {{-- Main --}}
        <div class="flex-1 lg:ml-0">
            <header class="flex h-16 items-center gap-3 border-b border-basalt/5 bg-millet/80 px-4 backdrop-blur lg:px-8">
                <button @click="sidebar=!sidebar" class="btn-ghost lg:hidden !p-2" aria-label="Menu">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="font-display text-lg font-semibold">{{ $title ?? 'Admin' }}</h1>
            </header>
            <main class="p-4 lg:p-8">
                {{-- Flash --}}
                <div x-data="{ show: false, msg: '' }"
                     x-on:notify.window="msg = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
                     x-show="show" x-transition style="display:none"
                     class="mb-5 rounded-xl bg-sage/15 px-4 py-3 text-sm font-semibold text-sage">
                    <span x-text="msg"></span>
                </div>
                @if (session('status'))
                    <div class="mb-5 rounded-xl bg-sage/15 px-4 py-3 text-sm font-semibold text-sage">{{ session('status') }}</div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
