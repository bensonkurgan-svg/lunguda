@props(['src' => null, 'id' => null, 'label' => 'Play pronunciation'])

@if ($src)
    <button type="button"
        x-data
        @click="$store.audio.play(@js(\Illuminate\Support\Facades\Storage::url($src)), @js($id))"
        :class="$store.audio.current === @js($id) ? 'pronounce is-playing' : 'pronounce'"
        class="shrink-0 transition hover:bg-sorghum-600 focus-visible:ring-2"
        aria-label="{{ $label }}">
        <span class="relative z-10">
            <svg x-show="$store.audio.current !== @js($id)" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            <svg x-show="$store.audio.current === @js($id)" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M6 5h4v14H6zM14 5h4v14h-4z"/></svg>
        </span>
    </button>
@else
    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-basalt/5 text-basalt/30" title="No audio yet">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 9v6m6-6v6M3 12a9 9 0 1018 0 9 9 0 00-18 0z"/></svg>
    </span>
@endif
