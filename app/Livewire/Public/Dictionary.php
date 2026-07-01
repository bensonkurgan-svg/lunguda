<?php

namespace App\Livewire\Public;

use App\Models\LungudaName;
use App\Models\Phrase;
use App\Models\Word;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Dictionary · Lunguda Heritage Archive')]
class Dictionary extends Component
{
    use WithPagination;

    #[Url(as: 'tab', history: true)]
    public string $tab = 'words';

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'dialect', history: true)]
    public string $dialect = '';

    public array $dialects = ['Cerin', 'Deele', 'Guyuk', 'Gwaanda', 'Kɔla'];

    public function updated($property): void
    {
        if (in_array($property, ['search', 'dialect', 'tab'])) {
            $this->resetPage();
        }
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        $term = trim($this->search);

        $results = match ($this->tab) {
            'names' => LungudaName::published()
                ->when($term, fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', "%{$term}%")->orWhere('meaning', 'like', "%{$term}%")))
                ->when($this->dialect, fn ($q) => $q->where('dialect', $this->dialect))
                ->orderBy('name')->paginate(12),

            'phrases' => Phrase::published()
                ->when($term, fn ($q) => $q->where(fn ($w) => $w->where('phrase', 'like', "%{$term}%")->orWhere('translation', 'like', "%{$term}%")))
                ->when($this->dialect, fn ($q) => $q->where('dialect', $this->dialect))
                ->orderByDesc('id')->paginate(12),

            default => Word::published()
                ->when($term, fn ($q) => $q->where(fn ($w) => $w->where('word', 'like', "%{$term}%")->orWhere('meaning', 'like', "%{$term}%")))
                ->when($this->dialect, fn ($q) => $q->where('dialect', $this->dialect))
                ->orderBy('word')->paginate(12),
        };

        return view('livewire.public.dictionary', compact('results', 'term'));
    }
}
