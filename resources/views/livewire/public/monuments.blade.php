<div class="mx-auto max-w-6xl px-4 py-12 md:py-16">
    <header class="max-w-2xl">
        <p class="eyebrow">Sites &amp; Monuments</p>
        <h1 class="mt-2 font-display text-4xl font-semibold">Places that hold the story</h1>
        <p class="mt-3 text-basalt/70">Sacred sites, landmarks and monuments of the Lunguda Plateau — mapped so they can be found, and described so they are remembered.</p>
    </header>

    {{-- Map: Leaflet + OpenStreetMap, loaded only when scrolled into view --}}
    @if ($mapped->isNotEmpty())
        <div class="mt-8 card overflow-hidden reveal"
             x-data="{
                loaded: false,
                points: @js($mapped),
                init() {
                    const obs = new IntersectionObserver((e) => {
                        if (e[0].isIntersecting && !this.loaded) { this.loaded = true; this.boot(); obs.disconnect(); }
                    }, { rootMargin: '200px' });
                    obs.observe(this.$el);
                },
                boot() {
                    const css = document.createElement('link');
                    css.rel = 'stylesheet'; css.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                    document.head.appendChild(css);
                    const js = document.createElement('script');
                    js.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                    js.onload = () => this.render();
                    document.head.appendChild(js);
                },
                render() {
                    const map = L.map(this.$refs.map, { scrollWheelZoom: false });
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap', maxZoom: 18,
                    }).addTo(map);
                    const group = [];
                    this.points.forEach(p => {
                        const m = L.marker([p.lat, p.lng]).addTo(map).bindPopup('<strong>'+p.name+'</strong><br>'+p.type.replace('_',' '));
                        group.push([p.lat, p.lng]);
                    });
                    map.fitBounds(group, { padding: [40, 40], maxZoom: 12 });
                }
             }">
            <div x-ref="map" class="h-[420px] w-full bg-millet-200">
                <div x-show="!loaded" class="grid h-full place-items-center text-basalt/40 text-sm">Map loads as you reach it…</div>
            </div>
        </div>
    @endif

    <div class="mt-8 grid gap-6 md:grid-cols-2">
        @forelse ($monuments as $m)
            <article class="card card-hover overflow-hidden reveal" wire:key="mon-{{ $m->id }}">
                @if ($m->image_path)
                    <img loading="lazy" src="{{ \Illuminate\Support\Facades\Storage::url($m->image_path) }}" alt="{{ $m->name }}" class="aspect-[16/9] w-full object-cover">
                @endif
                <div class="p-6">
                    <span class="chip capitalize">{{ str_replace('_', ' ', $m->type) }}</span>
                    <h2 class="mt-2 font-display text-2xl font-semibold">{{ $m->name }}</h2>
                    @if ($m->description)<p class="mt-2 text-basalt/75">{{ $m->description }}</p>@endif
                    @if ($m->significance)<p class="mt-3 rounded-xl bg-millet-200/60 p-3 text-sm text-basalt/70"><span class="font-semibold">Why it matters — </span>{{ $m->significance }}</p>@endif
                    @if ($m->latitude && $m->longitude)<p class="mt-3 font-mono text-xs text-basalt/45">{{ $m->latitude }}, {{ $m->longitude }}</p>@endif
                </div>
            </article>
        @empty
            <div class="md:col-span-2"><x-empty-state title="No sites mapped yet" message="Monuments and sacred sites are added from the admin area." /></div>
        @endforelse
    </div>
</div>
