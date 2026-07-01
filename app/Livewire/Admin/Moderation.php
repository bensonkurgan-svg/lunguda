<?php

namespace App\Livewire\Admin;

use App\Models\LungudaName;
use App\Models\OralTradition;
use App\Models\Phrase;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Moderation')]
class Moderation extends Component
{
    /** Map a short type key to its model class. */
    protected array $models = [
        'word' => Word::class,
        'phrase' => Phrase::class,
        'name' => LungudaName::class,
        'oral' => OralTradition::class,
    ];

    public function approve(string $type, int $id): void
    {
        $model = $this->resolve($type, $id);
        $model->forceFill(['status' => 'published', 'approved_by' => Auth::id()])->save();
        $this->dispatch('notify', message: 'Contribution approved and published.');
    }

    public function reject(string $type, int $id): void
    {
        $model = $this->resolve($type, $id);
        $model->update(['status' => 'draft']);
        $this->dispatch('notify', message: 'Contribution sent back to draft.');
    }

    protected function resolve(string $type, int $id)
    {
        abort_unless(isset($this->models[$type]), 404);

        return $this->models[$type]::findOrFail($id);
    }

    public function render()
    {
        $pending = [
            'word' => Word::where('status', 'pending')->with('contributor')->latest()->get(),
            'phrase' => Phrase::where('status', 'pending')->latest()->get(),
            'name' => LungudaName::where('status', 'pending')->latest()->get(),
            'oral' => OralTradition::where('status', 'pending')->latest()->get(),
        ];

        $total = collect($pending)->sum->count();

        return view('livewire.admin.moderation', compact('pending', 'total'));
    }
}
