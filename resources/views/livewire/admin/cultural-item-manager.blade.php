<div>
    <div class="flex items-center justify-between">
        <p class="text-sm text-basalt/60">{{ $items->count() }} piece{{ $items->count() === 1 ? '' : 's' }} documented</p>
        <button wire:click="create" class="btn-primary">+ Add piece</button>
    </div>

    @if ($showForm)
        <form wire:submit="save" class="card mt-5 p-6">
            <p class="font-display text-xl font-semibold">{{ $editingId ? 'Edit piece' : 'New cultural piece' }}</p>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Name *</label>
                    <input type="text" wire:model="name" class="field mt-1.5">
                    @error('name')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold">Category *</label>
                    <select wire:model="category" class="field mt-1.5 capitalize">
                        @foreach ($categories as $c)<option value="{{ $c }}">{{ ucfirst($c) }}</option>@endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Description</label>
                    <textarea wire:model="description" rows="3" class="field mt-1.5"></textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Significance / meaning</label>
                    <textarea wire:model="significance" rows="2" class="field mt-1.5"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold">Materials</label>
                    <input type="text" wire:model="materials" class="field mt-1.5">
                </div>
                <div>
                    <label class="text-sm font-semibold">Maker</label>
                    <input type="text" wire:model="maker_name" class="field mt-1.5">
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Image</label>
                    <input type="file" wire:model="image" accept="image/*" class="field mt-1.5 file:mr-3 file:rounded-full file:border-0 file:bg-basalt file:px-4 file:py-1.5 file:text-millet">
                    <div wire:loading wire:target="image" class="mt-1 text-sm text-basalt/50">Uploading…</div>
                    @error('image')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="mt-2 h-28 w-40 rounded-xl object-cover">
                    @elseif ($existingImage)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($existingImage) }}" class="mt-2 h-28 w-40 rounded-xl object-cover">
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

    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($items as $i)
            <div class="card overflow-hidden" wire:key="ci-{{ $i->id }}">
                @if ($i->image_path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($i->image_path) }}" class="aspect-[4/3] w-full object-cover">
                @endif
                <div class="p-4">
                    <span class="chip capitalize">{{ $i->category }}</span>
                    <p class="mt-1.5 font-display text-lg font-semibold">{{ $i->name }}</p>
                    <div class="mt-2 text-sm">
                        <button wire:click="edit({{ $i->id }})" class="font-semibold text-indigo2 hover:underline">Edit</button>
                        <button wire:click="delete({{ $i->id }})" wire:confirm="Delete this piece?" class="ml-3 font-semibold text-laterite hover:underline">Delete</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="card p-10 text-center text-basalt/50 sm:col-span-2 lg:col-span-3">No pieces yet.</p>
        @endforelse
    </div>
</div>
