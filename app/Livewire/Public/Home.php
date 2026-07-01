<?php

namespace App\Livewire\Public;

use App\Models\CulturalItem;
use App\Models\LungudaName;
use App\Models\OralTradition;
use App\Models\Ruler;
use App\Models\Word;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Lunguda Heritage Archive')]
class Home extends Component
{
    public function render()
    {
        $stats = Cache::remember('home.stats', 300, fn () => [
            'words' => Word::published()->count(),
            'names' => LungudaName::published()->count(),
            'stories' => OralTradition::published()->count(),
            'rulers' => Ruler::published()->count(),
            'items' => CulturalItem::published()->count(),
        ]);

        $featuredWord = Word::published()->whereNotNull('audio_path')->inRandomOrder()->first();

        return view('livewire.public.home', compact('stats', 'featuredWord'));
    }
}
