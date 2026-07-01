@props(['title' => 'Nothing here yet', 'message' => null])
<div class="card p-10 text-center">
    <div class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-sorghum/10 text-sorghum-600">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path d="M12 6v12m6-6H6"/></svg>
    </div>
    <p class="mt-4 font-display text-lg">{{ $title }}</p>
    @if ($message)<p class="mt-1 text-sm text-basalt/60">{{ $message }}</p>@endif
    {{ $slot }}
</div>
