<div>
    @if ($images->isEmpty())
        <x-empty-state title="No photographs yet" message="Images are added from the admin area." />
    @else
        <div class="columns-2 gap-4 sm:columns-3 lg:columns-4 [&>*]:mb-4">
            @foreach ($images as $image)
                <figure class="card overflow-hidden break-inside-avoid reveal" wire:key="gal-{{ $image->id }}">
                    <img loading="lazy" src="{{ \Illuminate\Support\Facades\Storage::url($image->image_path) }}"
                         alt="{{ $image->caption ?? 'Lunguda heritage photograph' }}"
                         class="w-full object-cover transition duration-500 hover:scale-[1.03]">
                    @if ($image->caption)
                        <figcaption class="px-4 py-3 text-sm text-basalt/65">{{ $image->caption }}</figcaption>
                    @endif
                </figure>
            @endforeach
        </div>
    @endif
</div>
