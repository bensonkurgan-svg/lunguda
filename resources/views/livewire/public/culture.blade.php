<div class="mx-auto max-w-6xl px-4 py-12 md:py-16">
    <header class="max-w-2xl">
        <p class="eyebrow">Culture &amp; Attire</p>
        <h1 class="mt-2 font-display text-4xl font-semibold">What we wear, make and keep</h1>
        <p class="mt-3 text-basalt/70">Cloth, regalia, instruments and craft — documented not just as objects, but with the meaning each carries and the hands that make them.</p>
    </header>

    <div class="mt-8 flex flex-wrap gap-2">
        <a href="{{ route('culture') }}" wire:navigate @class(['btn', $category === '' ? 'btn-ink' : 'btn-ghost'])>All</a>
        @foreach ($categories as $key => $label)
            <a href="{{ route('culture', ['cat' => $key]) }}" wire:navigate @class(['btn', $category === $key ? 'btn-ink' : 'btn-ghost'])>{{ $label }}</a>
        @endforeach
    </div>

    @if ($items->isEmpty())
        <div class="mt-10"><x-empty-state title="The collection is growing" message="Cultural pieces are added by the community's administrators." /></div>
    @else
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
             x-data="{ active: null }">
            @foreach ($items as $item)
                <button @click="active = {{ $item->id }}" class="card card-hover reveal overflow-hidden text-left" wire:key="ci-{{ $item->id }}">
                    <div class="aspect-[4/3] overflow-hidden bg-millet-200">
                        @if ($item->image_path)
                            <img loading="lazy" src="{{ \Illuminate\Support\Facades\Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        @else
                            <div class="grid h-full place-items-center text-basalt/25"><svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24"><path d="M3 16l5-5 4 4 3-3 6 6M3 8h18"/></svg></div>
                        @endif
                    </div>
                    <div class="p-5">
                        <span class="chip capitalize">{{ $item->category }}</span>
                        <h2 class="mt-2 font-display text-xl font-semibold">{{ $item->name }}</h2>
                        @if ($item->description)<p class="mt-1 line-clamp-2 text-sm text-basalt/65">{{ $item->description }}</p>@endif
                    </div>

                    {{-- Detail overlay --}}
                    <template x-teleport="body">
                        <div x-show="active === {{ $item->id }}" x-transition.opacity class="fixed inset-0 z-50 grid place-items-center bg-basalt/70 p-4" @click="active = null" style="display:none">
                            <div @click.stop class="card max-h-[88vh] w-full max-w-2xl overflow-auto p-0" x-transition>
                                @if ($item->image_path)<img src="{{ \Illuminate\Support\Facades\Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="aspect-video w-full rounded-t-2xl object-cover">@endif
                                <div class="p-7">
                                    <div class="flex items-start justify-between">
                                        <div><span class="chip capitalize">{{ $item->category }}</span>
                                            <h3 class="mt-2 font-display text-2xl font-semibold">{{ $item->name }}</h3></div>
                                        <button @click="active = null" class="btn-ghost h-9 w-9 !p-0">✕</button>
                                    </div>
                                    @if ($item->description)<p class="mt-4 text-basalt/80">{{ $item->description }}</p>@endif
                                    @if ($item->significance)<div class="mt-4 rounded-xl bg-indigo2/8 p-4"><p class="eyebrow text-indigo2">Significance</p><p class="mt-1.5 text-sm text-basalt/75">{{ $item->significance }}</p></div>@endif
                                    <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                        @if ($item->materials)<div><dt class="text-basalt/50">Materials</dt><dd class="font-semibold">{{ $item->materials }}</dd></div>@endif
                                        @if ($item->maker_name)<div><dt class="text-basalt/50">Maker</dt><dd class="font-semibold">{{ $item->maker_name }}</dd></div>@endif
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </template>
                </button>
            @endforeach
        </div>
    @endif
</div>
