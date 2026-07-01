<?php

namespace App\Livewire\Admin;

use App\Models\Clan;
use App\Models\Ruler;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Rulers')]
class RulerManager extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $ruler_title = '';
    public ?int $clan_id = null;
    public ?int $reign_start = null;
    public ?int $reign_end = null;
    public string $biography = '';
    public string $accomplishments = '';
    public string $vision = '';
    public int $order_index = 0;
    public string $status = 'published';

    public $portrait;
    public ?string $existingPortrait = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'ruler_title' => ['nullable', 'string', 'max:255'],
            'clan_id' => ['nullable', 'exists:clans,id'],
            'reign_start' => ['nullable', 'integer', 'min:0', 'max:2100'],
            'reign_end' => ['nullable', 'integer', 'min:0', 'max:2100'],
            'biography' => ['nullable', 'string'],
            'accomplishments' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'order_index' => ['integer', 'min:0'],
            'status' => ['required', 'in:published,pending,draft'],
            'portrait' => ['nullable', 'image', 'max:4096'], // 4 MB
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $r = Ruler::findOrFail($id);
        $this->editingId = $r->id;
        $this->name = $r->name;
        $this->ruler_title = (string) $r->title;
        $this->clan_id = $r->clan_id;
        $this->reign_start = $r->reign_start;
        $this->reign_end = $r->reign_end;
        $this->biography = (string) $r->biography;
        $this->accomplishments = (string) $r->accomplishments;
        $this->vision = (string) $r->vision;
        $this->order_index = $r->order_index;
        $this->status = $r->status;
        $this->existingPortrait = $r->portrait_path;
        $this->portrait = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        $payload = [
            'name' => $data['name'],
            'title' => $data['ruler_title'] ?: null,
            'clan_id' => $data['clan_id'],
            'reign_start' => $data['reign_start'],
            'reign_end' => $data['reign_end'],
            'biography' => $data['biography'] ?: null,
            'accomplishments' => $data['accomplishments'] ?: null,
            'vision' => $data['vision'] ?: null,
            'order_index' => $data['order_index'],
            'status' => $data['status'],
        ];

        if ($this->portrait) {
            if ($this->existingPortrait) {
                Storage::disk('public')->delete($this->existingPortrait);
            }
            $payload['portrait_path'] = $this->portrait->store('portraits', 'public');
        }

        if ($this->editingId) {
            Ruler::findOrFail($this->editingId)->update($payload);
        } else {
            Ruler::create($payload);
        }

        $this->dispatch('notify', message: $this->editingId ? 'Ruler updated.' : 'Ruler added.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        $r = Ruler::findOrFail($id);
        if ($r->portrait_path) {
            Storage::disk('public')->delete($r->portrait_path);
        }
        $r->delete();
        $this->dispatch('notify', message: 'Ruler deleted.');
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editingId', 'name', 'ruler_title', 'clan_id', 'reign_start', 'reign_end',
            'biography', 'accomplishments', 'vision', 'order_index', 'portrait', 'existingPortrait',
        ]);
        $this->status = 'published';
        $this->resetValidation();
    }

    public function render()
    {
        $rulers = Ruler::with('clan')->orderBy('order_index')->orderBy('reign_start')->get();
        $clans = Clan::orderBy('name')->get();

        return view('livewire.admin.ruler-manager', compact('rulers', 'clans'));
    }
}
