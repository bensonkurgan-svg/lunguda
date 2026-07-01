<?php

namespace App\Livewire\Public;

use App\Models\Clan;
use App\Models\Person;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Lineage · Lunguda Heritage Archive')]
class FamilyTrees extends Component
{
    public ?int $selectedClan = null;

    public function render()
    {
        $clans = Clan::withCount('people')->orderBy('name')->get();

        // Matrilineal-first: build the tree from founding mothers downward.
        $roots = collect();
        if ($this->selectedClan) {
            $roots = Person::published()
                ->where('clan_id', $this->selectedClan)
                ->whereNull('mother_id')
                ->with('childrenByMother.childrenByMother')
                ->orderBy('birth_year')->get();
        }

        return view('livewire.public.family-trees', compact('clans', 'roots'));
    }
}
