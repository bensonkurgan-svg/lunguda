<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="relative max-w-xs flex-1">
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search words…" class="field py-2.5">
        </div>
        <button wire:click="create" class="btn-primary">+ Add word</button>
    </div>

    {{-- Form --}}
    @if ($showForm)
        <form wire:submit="save" class="card mt-5 p-6">
            <p class="font-display text-xl font-semibold">{{ $editingId ? 'Edit word' : 'New word' }}</p>

            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Word (Lunguda) *</label>
                    <input type="text" wire:model="word" class="field mt-1.5">
                    @error('word')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold">Dialect *</label>
                    <select wire:model="dialect" class="field mt-1.5">
                        @foreach ($dialects as $d)<option value="{{ $d }}">{{ $d }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold">Part of speech</label>
                    <input type="text" wire:model="part_of_speech" class="field mt-1.5" placeholder="noun, verb…">
                </div>
                <div>
                    <label class="text-sm font-semibold">IPA / pronunciation</label>
                    <input type="text" wire:model="ipa" class="field mt-1.5">
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Meaning (English) *</label>
                    <textarea wire:model="meaning" rows="2" class="field mt-1.5"></textarea>
                    @error('meaning')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold">Example sentence</label>
                    <textarea wire:model="example_sentence" rows="2" class="field mt-1.5"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold">Example translation</label>
                    <textarea wire:model="example_translation" rows="2" class="field mt-1.5"></textarea>
                </div>

                {{-- Audio --}}
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold">Pronunciation audio</label>
                    <input type="file" wire:model="audio" accept="audio/*" class="field mt-1.5 file:mr-3 file:rounded-full file:border-0 file:bg-basalt file:px-4 file:py-1.5 file:text-millet">
                    <div wire:loading wire:target="audio" class="mt-1 text-sm text-basalt/50">Uploading…</div>
                    @error('audio')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
                    @if ($existingAudio && ! $audio)
                        <audio controls class="mt-2 h-9 w-full max-w-xs" src="{{ \Illuminate\Support\Facades\Storage::url($existingAudio) }}"></audio>
                    @endif
                </div>

                <div>
                    <label class="text-sm font-semibold">Recorded by</label>
                    <input type="text" wire:model="recorded_by_name" class="field mt-1.5" placeholder="Speaker / elder name">
                </div>
                <div>
                    <label class="text-sm font-semibold">Status</label>
                    <select wire:model="status" class="field mt-1.5">
                        <option value="published">Published</option>
                        <option value="pending">Pending review</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <label class="sm:col-span-2 flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model="consent_given" class="rounded border-basalt/20 text-sorghum focus:ring-sorghum">
                    The speaker has given consent for this recording to be archived and shared.
                </label>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update word' : 'Save word' }}</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
                <button type="button" wire:click="cancel" class="btn-ghost">Cancel</button>
            </div>
        </form>
    @endif

    {{-- List --}}
    <div class="card mt-5 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-basalt/5 text-xs uppercase tracking-wide text-basalt/55">
                <tr>
                    <th class="px-5 py-3">Word</th>
                    <th class="px-5 py-3">Meaning</th>
                    <th class="px-5 py-3">Dialect</th>
                    <th class="px-5 py-3">Audio</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-basalt/5">
                @forelse ($words as $w)
                    <tr wire:key="word-{{ $w->id }}" class="hover:bg-millet-200/40">
                        <td class="px-5 py-3 font-display text-base font-semibold">{{ $w->word }}</td>
                        <td class="px-5 py-3 text-basalt/70">{{ \Illuminate\Support\Str::limit($w->meaning, 50) }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $w->dialect }}</span></td>
                        <td class="px-5 py-3">@if ($w->audio_path)<span class="text-sage">●</span>@else<span class="text-basalt/25">—</span>@endif</td>
                        <td class="px-5 py-3">
                            <span @class([
                                'rounded-full px-2.5 py-1 text-xs font-semibold',
                                'bg-sage/15 text-sage' => $w->status === 'published',
                                'bg-sorghum/15 text-sorghum-600' => $w->status === 'pending',
                                'bg-basalt/10 text-basalt/60' => $w->status === 'draft',
                            ])>{{ $w->status }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <button wire:click="edit({{ $w->id }})" class="font-semibold text-indigo2 hover:underline">Edit</button>
                            <button wire:click="delete({{ $w->id }})" wire:confirm="Delete this word? This cannot be undone." class="ml-3 font-semibold text-laterite hover:underline">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-basalt/50">No words yet. Add the first entry.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $words->links() }}</div>
</div>
