<div>
    @if ($pending > 0)
        <a href="{{ route('admin.moderation') }}" wire:navigate class="mb-6 flex items-center justify-between rounded-2xl bg-sorghum/10 px-5 py-4 ring-1 ring-sorghum/20 transition hover:bg-sorghum/15">
            <div>
                <p class="font-semibold text-sorghum-600">{{ $pending }} contribution{{ $pending === 1 ? '' : 's' }} awaiting review</p>
                <p class="text-sm text-basalt/60">Community submissions that need approval before they go live.</p>
            </div>
            <span class="btn-primary">Review now</span>
        </a>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($counts as $label => $value)
            <div class="card p-5">
                <p class="font-mono text-3xl font-semibold text-basalt">{{ number_format($value) }}</p>
                <p class="mt-1 text-sm text-basalt/55">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        <p class="eyebrow">Manage content</p>
        <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['admin.words','Words','Add and edit dictionary entries with audio.'],
                ['admin.rulers','Rulers','Maintain the chieftaincy timeline and portraits.'],
                ['admin.culture','Culture & attire','Document cloth, regalia, craft and food.'],
            ] as [$route,$title,$desc])
                <a href="{{ route($route) }}" wire:navigate class="card card-hover p-5">
                    <p class="font-display text-lg font-semibold">{{ $title }}</p>
                    <p class="mt-1 text-sm text-basalt/60">{{ $desc }}</p>
                </a>
            @endforeach
        </div>
        <p class="mt-4 text-xs text-basalt/45">Phrases, names, oral traditions, monuments, clans, people, gallery and users follow the same manager pattern — see <span class="font-mono">docs/EXTENDING.md</span>.</p>
    </div>
</div>
