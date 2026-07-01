<div>
    <div class="flex items-center justify-between">
        <p class="text-sm text-basalt/60">{{ $rulers->count() }} ruler{{ $rulers->count() === 1 ? '' : 's' }} on the timeline</p>
        <button wire:click="create" class="btn-primary">+ Add ruler</button>
    </div>

    @if ($showForm)
        <form wire:submit="save" class="card mt-5 p-6">
            <p class="font-display text-xl font-semibold">{{ $editingId ? 'Edit ruler' : 'New ruler' }}</p>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Name *</label>
                    <input type="text" wire:model="name" class="field mt-1.5">
                    @error('name')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold">Title</label>
                    <input type="text" wire:model="ruler_title" class="field mt-1.5" placeholder="Chief of Jessu">
                </div>
                <div>
                    <label class="text-sm font-semibold">Clan</label>
                    <select wire:model="clan_id" class="field mt-1.5">
                        <option value="">—</option>
                        @foreach ($clans as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold">Order on timeline</label>
                    <input type="number" wire:model="order_index" class="field mt-1.5" min="0">
                </div>
                <div>
                    <label class="text-sm font-semibold">Reign start (year)</label>
                    <input type="number" wire:model="reign_start" class="field mt-1.5" placeholder="1920">
                </div>
                <div>
                    <label class="text-sm font-semibold">Reign end (year)</label>
                    <input type="number" wire:model="reign_end" class="field mt-1.5" placeholder="1955">
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Biography</label>
                    <textarea wire:model="biography" rows="3" class="field mt-1.5"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold">Accomplishments</label>
                    <textarea wire:model="accomplishments" rows="3" class="field mt-1.5"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold">Vision &amp; dreams</label>
                    <textarea wire:model="vision" rows="3" class="field mt-1.5"></textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Portrait</label>
                    <input type="file" wire:model="portrait" accept="image/*" class="field mt-1.5 file:mr-3 file:rounded-full file:border-0 file:bg-basalt file:px-4 file:py-1.5 file:text-millet">
                    <div wire:loading wire:target="portrait" class="mt-1 text-sm text-basalt/50">Uploading…</div>
                    @error('portrait')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
                    @if ($portrait)
                        <img src="{{ $portrait->temporaryUrl() }}" class="mt-2 h-24 w-24 rounded-xl object-cover">
                    @elseif ($existingPortrait)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($existingPortrait) }}" class="mt-2 h-24 w-24 rounded-xl object-cover">
                    @endif
                </div>
                <div>
                    <label class="text-sm font-semibold">Status</label>
                    <select wire:model="status" class="field mt-1.5">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update' : 'Save' }}</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
                <button type="button" wire:click="cancel" class="btn-ghost">Cancel</button>
            </div>
        </form>
    @endif

    <div class="mt-5 grid gap-4 sm:grid-cols-2">
        @forelse ($rulers as $r)
            <div class="card p-5 flex gap-4" wire:key="ruler-{{ $r->id }}">
                @if ($r->portrait_path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($r->portrait_path) }}" class="h-16 w-16 rounded-xl object-cover">
                @else
                    <div class="grid h-16 w-16 place-items-center rounded-xl bg-indigo2/10 font-display text-xl text-indigo2">{{ \Illuminate\Support\Str::substr($r->name, 0, 1) }}</div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="font-display text-lg font-semibold">{{ $r->name }}</p>
                    <p class="font-mono text-xs text-sorghum-600">{{ $r->reignLabel() }}</p>
                    @if ($r->title)<p class="text-sm text-basalt/55">{{ $r->title }}</p>@endif
                    <div class="mt-2 text-sm">
                        <button wire:click="edit({{ $r->id }})" class="font-semibold text-indigo2 hover:underline">Edit</button>
                        <button wire:click="delete({{ $r->id }})" wire:confirm="Delete this ruler?" class="ml-3 font-semibold text-laterite hover:underline">Delete</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="sm:col-span-2 card p-10 text-center text-basalt/50">No rulers yet. Add the first to start the timeline.</p>
        @endforelse
    </div>
</div>
