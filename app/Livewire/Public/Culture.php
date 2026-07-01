<?php

namespace App\Livewire\Public;

use App\Models\CulturalItem;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Culture & Attire · Lunguda Heritage Archive')]
class Culture extends Component
{
    #[Url(as: 'cat', history: true)]
    public string $category = '';

    public array $categories = ['attire' => 'Attire', 'regalia' => 'Regalia', 'craft' => 'Craft', 'instrument' => 'Instruments', 'food' => 'Food'];

    public function render()
    {
        $items = CulturalItem::published()
            ->when($this->category, fn ($q) => $q->where('category', $this->category))
            ->orderBy('name')->get();

        return view('livewire.public.culture', compact('items'));
    }
}
