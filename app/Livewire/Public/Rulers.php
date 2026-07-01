<?php

namespace App\Livewire\Public;

use App\Models\Ruler;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Rulers & History · Lunguda Heritage Archive')]
class Rulers extends Component
{
    public function render()
    {
        $rulers = Ruler::published()->with('clan')
            ->orderBy('order_index')
            ->orderByRaw('reign_start is null, reign_start')
            ->get();

        return view('livewire.public.rulers', compact('rulers'));
    }
}
