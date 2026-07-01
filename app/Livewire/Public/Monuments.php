<?php

namespace App\Livewire\Public;

use App\Models\Monument;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Sites & Monuments · Lunguda Heritage Archive')]
class Monuments extends Component
{
    public function render()
    {
        $monuments = Monument::published()->orderBy('name')->get();

        $mapped = $monuments->filter(fn ($m) => $m->latitude && $m->longitude)
            ->map(fn ($m) => [
                'name' => $m->name,
                'lat' => (float) $m->latitude,
                'lng' => (float) $m->longitude,
                'type' => $m->type,
            ])->values();

        return view('livewire.public.monuments', compact('monuments', 'mapped'));
    }
}
