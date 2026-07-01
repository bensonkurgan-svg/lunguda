<div class="mx-auto max-w-5xl px-4 py-12 md:py-16">
    <header class="max-w-2xl">
        <p class="eyebrow">Lineage</p>
        <h1 class="mt-2 font-display text-4xl font-semibold">Clans &amp; family trees</h1>
        <p class="mt-3 text-basalt/70">Lunguda society is matrilineal — descent runs through the mother's line. These trees are built mother-to-child, the way the community itself traces belonging.</p>
    </header>

    <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($clans as $clan)
            <button wire:click="$set('selectedClan', {{ $clan->id }})"
                @class(['card card-hover p-5 text-left reveal', 'ring-2 ring-sorghum' => $selectedClan === $clan->id])
                wire:key="clan-{{ $clan->id }}">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-xl font-semibold">{{ $clan->name }}</h2>
                    <span class="font-mono text-sm text-basalt/45">{{ $clan->people_count }}</span>
                </div>
                @if ($clan->totem)<p class="mt-1 text-xs uppercase tracking-wide text-sorghum-600">Totem · {{ $clan->totem }}</p>@endif
                @if ($clan->description)<p class="mt-2 line-clamp-2 text-sm text-basalt/65">{{ $clan->description }}</p>@endif
            </button>
        @empty
            <div class="sm:col-span-2 lg:col-span-3"><x-empty-state title="No clans recorded yet" message="Clans and their people are added from the admin area." /></div>
        @endforelse
    </div>

    @if ($selectedClan)
        <div class="mt-10 card p-6 md:p-8" wire:loading.class="opacity-50" wire:target="selectedClan">
            <p class="eyebrow">Matrilineal tree</p>
            @if ($roots->isEmpty())
                <p class="mt-3 text-basalt/60">No founding mothers have been recorded for this clan yet.</p>
            @else
                <ul class="mt-5 space-y-3">
                    @foreach ($roots as $person)
                        @include('partials.person-node', ['person' => $person])
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
</div>
