<div class="mx-auto max-w-4xl px-4 py-12 md:py-16">
    <header class="max-w-2xl">
        <p class="eyebrow">Rulers &amp; History</p>
        <h1 class="mt-2 font-display text-4xl font-semibold">The line of Jessu</h1>
        <p class="mt-3 text-basalt/70">The traditional rulers who have guided the Lunguda of Jessu — their reigns, what they built, and the vision each carried for the people.</p>
    </header>

    @if ($rulers->isEmpty())
        <div class="mt-10"><x-empty-state title="The chronicle is being written" message="Rulers and their histories are added by the community's administrators." /></div>
    @else
        <ol class="relative mt-12 border-l-2 border-sorghum/25 pl-8 md:pl-10">
            @foreach ($rulers as $ruler)
                <li class="relative mb-12 reveal" wire:key="ruler-{{ $ruler->id }}">
                    <span class="absolute -left-[42px] md:-left-[50px] grid h-8 w-8 place-items-center rounded-full bg-sorghum text-white text-xs font-mono shadow-soft">{{ $loop->iteration }}</span>
                    <div class="card p-6 md:p-7">
                        <div class="flex flex-col gap-5 sm:flex-row">
                            @if ($ruler->portrait_path)
                                <img loading="lazy" src="{{ \Illuminate\Support\Facades\Storage::url($ruler->portrait_path) }}"
                                     alt="Portrait of {{ $ruler->name }}"
                                     class="h-28 w-28 shrink-0 rounded-xl object-cover shadow-soft">
                            @else
                                <div class="grid h-28 w-28 shrink-0 place-items-center rounded-xl bg-indigo2/10 font-display text-3xl text-indigo2">{{ \Illuminate\Support\Str::substr($ruler->name, 0, 1) }}</div>
                            @endif
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-baseline gap-x-3">
                                    <h2 class="font-display text-2xl font-semibold">{{ $ruler->name }}</h2>
                                    @if ($ruler->title)<span class="chip">{{ $ruler->title }}</span>@endif
                                </div>
                                <p class="mt-1 font-mono text-sm text-sorghum-600">{{ $ruler->reignLabel() }}</p>
                                @if ($ruler->clan)<p class="text-sm text-basalt/55">{{ $ruler->clan->name }} clan</p>@endif
                                @if ($ruler->biography)<p class="mt-3 text-basalt/75">{{ $ruler->biography }}</p>@endif
                            </div>
                        </div>

                        @if ($ruler->accomplishments || $ruler->vision)
                            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                @if ($ruler->accomplishments)
                                    <div class="rounded-xl bg-millet-200/60 p-4">
                                        <p class="eyebrow">Accomplishments</p>
                                        <p class="mt-1.5 text-sm text-basalt/75">{{ $ruler->accomplishments }}</p>
                                    </div>
                                @endif
                                @if ($ruler->vision)
                                    <div class="rounded-xl bg-indigo2/8 p-4">
                                        <p class="eyebrow text-indigo2">Vision &amp; dreams</p>
                                        <p class="mt-1.5 text-sm text-basalt/75">{{ $ruler->vision }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    @endif
</div>
