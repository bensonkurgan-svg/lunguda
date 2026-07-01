<div class="mx-auto max-w-4xl px-4 py-12 md:py-16">
    <header class="max-w-2xl">
        <p class="eyebrow">Oral Traditions</p>
        <h1 class="mt-2 font-display text-4xl font-semibold">Voices of the elders</h1>
        <p class="mt-3 text-basalt/70">Folktales, proverbs, songs and histories — recorded from those who carry them, with the Lunguda transcript and an English translation beside each one.</p>
    </header>

    <div class="mt-8 flex flex-wrap gap-2">
        <button wire:click="setType('')" @class(['btn', $type === '' ? 'btn-ink' : 'btn-ghost'])>All</button>
        @foreach ($types as $key => $label)
            <button wire:click="setType('{{ $key }}')" @class(['btn', $type === $key ? 'btn-ink' : 'btn-ghost'])>{{ $label }}</button>
        @endforeach
    </div>

    <div class="mt-8 space-y-5" wire:loading.class="opacity-50" wire:target="setType,nextPage,previousPage">
        @forelse ($items as $item)
            <article class="card p-6 reveal" x-data="{ open: false }" wire:key="ot-{{ $item->id }}">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="chip capitalize">{{ $item->type }}</span>
                        <h2 class="mt-2 font-display text-2xl font-semibold">{{ $item->title }}</h2>
                        <p class="mt-1 text-sm text-basalt/55">
                            @if ($item->narrator_name)Narrated by {{ $item->narrator_name }} · @endif
                            <span class="font-mono">{{ $item->dialect }}</span>
                            @if ($item->recorded_on) · {{ $item->recorded_on->format('Y') }}@endif
                        </p>
                    </div>
                    <x-pronounce :src="$item->audio_path" :id="'ot-'.$item->id" />
                </div>

                @if ($item->video_url)
                    <div class="mt-4 aspect-video overflow-hidden rounded-xl bg-basalt/5">
                        <iframe loading="lazy" class="h-full w-full" src="{{ $item->video_url }}" title="{{ $item->title }}" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                @endif

                @if ($item->transcript || $item->translation)
                    <button @click="open = !open" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sorghum-600">
                        <span x-text="open ? 'Hide text' : 'Read transcript & translation'"></span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" :class="open && 'rotate-180'" class="transition"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-4 grid gap-4 sm:grid-cols-2">
                        @if ($item->transcript)<div class="rounded-xl bg-millet-200/60 p-4"><p class="eyebrow">Lunguda</p><p class="mt-2 whitespace-pre-line text-sm leading-relaxed">{{ $item->transcript }}</p></div>@endif
                        @if ($item->translation)<div class="rounded-xl bg-white p-4 border border-basalt/5"><p class="eyebrow">English</p><p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-basalt/75">{{ $item->translation }}</p></div>@endif
                    </div>
                @endif
            </article>
        @empty
            <x-empty-state title="No recordings yet" message="The first stories and proverbs are being gathered from the community's elders." />
        @endforelse

        <div class="mt-8">{{ $items->links() }}</div>
    </div>
</div>
