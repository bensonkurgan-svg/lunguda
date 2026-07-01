<div class="mx-auto max-w-5xl px-4 py-12 md:py-16">
    <header class="max-w-2xl">
        <p class="eyebrow">Dictionary</p>
        <h1 class="mt-2 font-display text-4xl font-semibold">Search the Nʋngʋra word</h1>
        <p class="mt-3 text-basalt/70">Words, names and everyday phrases — each entry carries a recording and the dialect it comes from.</p>
    </header>

    {{-- Tabs --}}
    <div class="mt-8 inline-flex rounded-full bg-basalt/5 p-1">
        @foreach (['words' => 'Words', 'names' => 'Names', 'phrases' => 'Phrases'] as $key => $label)
            <button wire:click="setTab('{{ $key }}')"
                @class([
                    'rounded-full px-5 py-2 text-sm font-semibold transition',
                    'bg-white text-basalt shadow-soft' => $tab === $key,
                    'text-basalt/60 hover:text-basalt' => $tab !== $key,
                ])>{{ $label }}</button>
        @endforeach
    </div>

    {{-- Controls --}}
    <div class="mt-5 flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-basalt/35" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/></svg>
            <input type="search" wire:model.live.debounce.300ms="search"
                   placeholder="Search in Lunguda or English…"
                   class="field pl-11 py-3" aria-label="Search the dictionary">
        </div>
        <select wire:model.live="dialect" class="field py-3 sm:w-52" aria-label="Filter by dialect">
            <option value="">All dialects</option>
            @foreach ($dialects as $d)<option value="{{ $d }}">{{ $d }}</option>@endforeach
        </select>
    </div>

    {{-- Results --}}
    <div class="mt-8" wire:loading.class="opacity-50" wire:target="search,dialect,tab,nextPage,previousPage,gotoPage">
        @if ($results->isEmpty())
            <x-empty-state title="No entries found"
                message="{{ $term ? 'Nothing matched “'.$term.'”. Try another spelling or clear the filters.' : 'This section is still being recorded.' }}" />
        @else
            <div class="grid gap-3">
                @foreach ($results as $row)
                    <article class="card p-5 flex items-start gap-4 reveal" wire:key="{{ $tab }}-{{ $row->id }}">
                        @if ($tab === 'words')
                            <x-pronounce :src="$row->audio_path" :id="'w-'.$row->id" />
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-baseline gap-x-3 gap-y-1">
                                    <h3 class="font-display text-xl font-semibold">{{ $row->word }}</h3>
                                    @if ($row->part_of_speech)<span class="text-xs italic text-basalt/45">{{ $row->part_of_speech }}</span>@endif
                                    @if ($row->ipa)<span class="font-mono text-xs text-basalt/40">/{{ $row->ipa }}/</span>@endif
                                    <x-dialect-badge :dialect="$row->dialect" />
                                </div>
                                <p class="mt-1.5 text-basalt/80">{{ $row->meaning }}</p>
                                @if ($row->example_sentence)
                                    <p class="mt-2 text-sm italic text-basalt/55">“{{ $row->example_sentence }}”
                                        @if ($row->example_translation)<span class="not-italic">— {{ $row->example_translation }}</span>@endif
                                    </p>
                                @endif
                            </div>
                        @elseif ($tab === 'names')
                            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-indigo2/10 font-display text-lg text-indigo2">{{ \Illuminate\Support\Str::substr($row->name, 0, 1) }}</div>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-baseline gap-x-3">
                                    <h3 class="font-display text-xl font-semibold">{{ $row->name }}</h3>
                                    <span class="chip capitalize">{{ $row->gender }}</span>
                                    <x-dialect-badge :dialect="$row->dialect" />
                                </div>
                                <p class="mt-1.5 text-basalt/80">{{ $row->meaning }}</p>
                                @if ($row->origin)<p class="mt-1 text-sm text-basalt/55">Origin: {{ $row->origin }}</p>@endif
                            </div>
                        @else
                            <x-pronounce :src="$row->audio_path" :id="'p-'.$row->id" />
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-baseline gap-x-3">
                                    <h3 class="font-display text-lg font-semibold">{{ $row->phrase }}</h3>
                                    <span class="chip capitalize">{{ str_replace('_', ' ', $row->category) }}</span>
                                    <x-dialect-badge :dialect="$row->dialect" />
                                </div>
                                <p class="mt-1 text-basalt/80">{{ $row->translation }}</p>
                                @if ($row->usage_notes)<p class="mt-1 text-sm text-basalt/55">{{ $row->usage_notes }}</p>@endif
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>

            <div class="mt-8">{{ $results->links() }}</div>
        @endif
    </div>
</div>
