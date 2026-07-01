<div>
    {{-- ===== Hero: language as the thesis ===== --}}
    <section class="relative overflow-hidden">
        <div class="mx-auto max-w-6xl px-4 pt-16 pb-12 md:pt-24 md:pb-20">
            <div class="grid items-center gap-12 lg:grid-cols-12">
                <div class="lg:col-span-7">
                    <p class="eyebrow animate-rise">A living archive of Jessu · Gombe State</p>
                    <h1 class="mt-4 font-display text-4xl font-semibold leading-[1.05] sm:text-6xl">
                        The words, lineage and<br>
                        <span class="text-sorghum-600">living culture</span> of the<br>
                        Nʋngʋra people.
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-basalt/70">
                        A community-owned record of the Lunguda language and heritage — kept by the people who speak it,
                        for the generations who will. Every word carries a voice.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('dictionary') }}" wire:navigate class="btn-primary">Explore the dictionary</a>
                        <a href="{{ route('oral-traditions') }}" wire:navigate class="btn-ghost">Hear our elders</a>
                    </div>
                </div>

                {{-- Featured spoken word — the signature pronounce control --}}
                <div class="lg:col-span-5">
                    @if ($featuredWord)
                        <div class="card card-hover p-7 reveal">
                            <p class="eyebrow">Word of the moment</p>
                            <div class="mt-4 flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-display text-3xl font-semibold">{{ $featuredWord->word }}</p>
                                    @if ($featuredWord->ipa)<p class="mt-1 font-mono text-sm text-basalt/50">/{{ $featuredWord->ipa }}/</p>@endif
                                </div>
                                <x-pronounce :src="$featuredWord->audio_path" :id="'home-'.$featuredWord->id" />
                            </div>
                            <p class="mt-4 text-basalt/75">{{ $featuredWord->meaning }}</p>
                            @if ($featuredWord->example_sentence)
                                <div class="mt-5 rounded-xl bg-millet-200/60 p-4">
                                    <p class="text-sm italic">“{{ $featuredWord->example_sentence }}”</p>
                                    @if ($featuredWord->example_translation)<p class="mt-1 text-sm text-basalt/55">{{ $featuredWord->example_translation }}</p>@endif
                                </div>
                            @endif
                            <x-dialect-badge :dialect="$featuredWord->dialect" />
                        </div>
                    @else
                        <div class="card p-7 reveal">
                            <p class="font-display text-2xl">Nʋngʋra</p>
                            <p class="mt-2 text-basalt/65">The dictionary is being recorded word by word. Sign in to add the first entries with audio.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Living counts ===== --}}
    <section class="mx-auto max-w-6xl px-4">
        <div class="card grid grid-cols-2 gap-px overflow-hidden bg-basalt/5 sm:grid-cols-5">
            @foreach ([
                ['words','Words recorded'],['names','Names'],['stories','Oral traditions'],
                ['rulers','Rulers'],['items','Culture pieces'],
            ] as [$key,$label])
                <div class="bg-white/80 p-6 text-center">
                    <p class="font-mono text-3xl font-semibold text-sorghum-600">{{ number_format($stats[$key]) }}</p>
                    <p class="mt-1 text-xs uppercase tracking-wide text-basalt/55">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== Explore grid ===== --}}
    <section class="mx-auto max-w-6xl px-4 py-16">
        <p class="eyebrow">What lives here</p>
        <h2 class="mt-2 font-display text-3xl font-semibold">Six ways into the heritage</h2>
        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['dictionary','Dictionary','Words, names and phrases — each with a spoken recording and dialect tag.','🗣'],
                ['oral-traditions','Oral traditions','Folktales, proverbs and songs from elders, transcribed and translated.','📖'],
                ['rulers','Rulers & history','The chieftaincy line of Jessu — reigns, deeds and the visions they carried.','👑'],
                ['family-trees','Lineage','Clans and family trees, traced through the matrilineal line.','🌿'],
                ['culture','Culture & attire','Cloth, regalia, craft and food — and what each piece means.','🧵'],
                ['monuments','Sites & monuments','Sacred places and landmarks of the Lunguda Plateau, mapped.','⛰'],
            ] as [$route,$title,$desc,$icon])
                <a href="{{ route($route) }}" wire:navigate class="card card-hover reveal p-6 block">
                    <span class="text-2xl">{{ $icon }}</span>
                    <p class="mt-3 font-display text-xl font-semibold">{{ $title }}</p>
                    <p class="mt-1.5 text-sm text-basalt/65">{{ $desc }}</p>
                    <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-sorghum-600">Open
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ===== Why it matters ===== --}}
    <section class="mx-auto max-w-6xl px-4 pb-4">
        <div class="card reveal overflow-hidden md:grid md:grid-cols-5">
            <div class="bg-indigo2 p-8 text-millet md:col-span-2">
                <p class="eyebrow text-sorghum-400">Why now</p>
                <p class="mt-3 font-display text-2xl leading-snug">A language is only as safe as the children who still speak it.</p>
            </div>
            <div class="p-8 md:col-span-3">
                <p class="leading-relaxed text-basalt/75">
                    Lunguda is a minority language of the Niger-Congo family with five dialects — spoken by tens of
                    thousands, yet under pressure as younger generations shift to dominant languages. This archive is a
                    preventive act: documenting what is still strong, and giving the next generation a place to learn it.
                </p>
                <p class="mt-4 leading-relaxed text-basalt/75">
                    Everything here is built to outlast the website — recordings, transcriptions and meanings can be
                    exported and deposited in open language archives so the work is never lost.
                </p>
            </div>
        </div>
    </section>
</div>
