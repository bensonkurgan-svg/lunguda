<?php

namespace App\Livewire\Admin;

use App\Models\CulturalItem;
use App\Models\LungudaName;
use App\Models\Monument;
use App\Models\OralTradition;
use App\Models\Phrase;
use App\Models\Ruler;
use App\Models\Word;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $pending = collect([
            Word::where('status', 'pending')->count(),
            Phrase::where('status', 'pending')->count(),
            LungudaName::where('status', 'pending')->count(),
            OralTradition::where('status', 'pending')->count(),
        ])->sum();

        $counts = [
            'Words' => Word::count(),
            'Phrases' => Phrase::count(),
            'Names' => LungudaName::count(),
            'Oral traditions' => OralTradition::count(),
            'Rulers' => Ruler::count(),
            'Culture pieces' => CulturalItem::count(),
            'Monuments' => Monument::count(),
        ];

        return view('livewire.admin.dashboard', compact('counts', 'pending'));
    }
}
