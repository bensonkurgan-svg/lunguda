<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Gallery · Lunguda Heritage Archive')]
class Gallery extends Component
{
    public function render()
    {
        return view('livewire.public.gallery');
    }
}
