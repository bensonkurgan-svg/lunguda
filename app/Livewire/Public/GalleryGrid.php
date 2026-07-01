<?php

namespace App\Livewire\Public;

use App\Models\GalleryImage;
use Livewire\Attributes\Lazy;
use Livewire\Component;

/**
 * Image-heavy, so it is lazy-loaded: Livewire renders the skeleton
 * placeholder() first, then fetches the real grid after the page paints.
 */
#[Lazy]
class GalleryGrid extends Component
{
    public function placeholder()
    {
        return view('livewire.public.gallery-grid-placeholder');
    }

    public function render()
    {
        $images = GalleryImage::orderByDesc('id')->get();

        return view('livewire.public.gallery-grid', compact('images'));
    }
}
