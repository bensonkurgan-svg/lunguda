<?php

namespace App\Livewire\Public;

use App\Models\OralTradition;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Oral Traditions · Lunguda Heritage Archive')]
class OralTraditions extends Component
{
    use WithPagination;

    #[Url(as: 'type', history: true)]
    public string $type = '';

    public array $types = ['story' => 'Folktales', 'proverb' => 'Proverbs', 'song' => 'Songs', 'history' => 'Histories'];

    public function setType(string $type): void
    {
        $this->type = $type;
        $this->resetPage();
    }

    public function render()
    {
        $items = OralTradition::published()
            ->when($this->type, fn ($q) => $q->where('type', $this->type))
            ->orderByDesc('id')->paginate(8);

        return view('livewire.public.oral-traditions', compact('items'));
    }
}
