<div>
    @if ($total === 0)
        <div class="card p-12 text-center">
            <div class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-sage/15 text-sage">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="mt-4 font-display text-xl">All caught up</p>
            <p class="mt-1 text-sm text-basalt/55">No community contributions are waiting for review.</p>
        </div>
    @else
        <p class="text-sm text-basalt/60">{{ $total }} item{{ $total === 1 ? '' : 's' }} awaiting review.</p>

        @php $labels = ['word' => 'Words', 'phrase' => 'Phrases', 'name' => 'Names', 'oral' => 'Oral traditions']; @endphp
        @foreach ($pending as $type => $rows)
            @if ($rows->isNotEmpty())
                <section class="mt-6">
                    <p class="eyebrow">{{ $labels[$type] }}</p>
                    <div class="mt-3 space-y-3">
                        @foreach ($rows as $row)
                            <div class="card p-5 flex flex-wrap items-start justify-between gap-4" wire:key="{{ $type }}-{{ $row->id }}">
                                <div class="min-w-0 flex-1">
                                    <p class="font-display text-lg font-semibold">
                                        {{ $row->word ?? $row->phrase ?? $row->name ?? $row->title }}
                                    </p>
                                    <p class="mt-1 text-sm text-basalt/65">
                                        {{ \Illuminate\Support\Str::limit($row->meaning ?? $row->translation ?? $row->transcript ?? '', 120) }}
                                    </p>
                                    <p class="mt-1 text-xs text-basalt/45">
                                        @if ($type === 'word' && $row->contributor)Submitted by {{ $row->contributor->name }} · @endif
                                        @isset($row->dialect)<span class="font-mono">{{ $row->dialect }}</span>@endisset
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="approve('{{ $type }}', {{ $row->id }})" class="btn-primary">Approve</button>
                                    <button wire:click="reject('{{ $type }}', {{ $row->id }})" class="btn-ghost">Send back</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
    @endif
</div>
