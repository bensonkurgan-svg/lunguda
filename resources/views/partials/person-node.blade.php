{{-- Recursive matrilineal node. Expects $person. --}}
<li wire:key="person-{{ $person->id }}">
    <div class="inline-flex items-center gap-2 rounded-xl bg-white border border-basalt/10 px-3 py-2 shadow-soft">
        <span class="grid h-7 w-7 place-items-center rounded-full bg-sorghum/15 text-xs font-semibold text-sorghum-600">{{ \Illuminate\Support\Str::substr($person->name, 0, 1) }}</span>
        <span class="text-sm font-semibold">{{ $person->name }}</span>
        @if ($person->birth_year)<span class="font-mono text-xs text-basalt/45">{{ $person->birth_year }}@if ($person->death_year)–{{ $person->death_year }}@endif</span>@endif
    </div>
    @if ($person->childrenByMother->isNotEmpty())
        <ul class="mt-2 space-y-2 border-l border-dashed border-basalt/20 pl-5">
            @foreach ($person->childrenByMother as $child)
                @include('partials.person-node', ['person' => $child])
            @endforeach
        </ul>
    @endif
</li>
