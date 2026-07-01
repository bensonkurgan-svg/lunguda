<?php

namespace App\Livewire\Admin;

use App\Models\CulturalItem;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Culture & Attire')]
class CulturalItemManager extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $category = 'attire';
    public string $description = '';
    public string $significance = '';
    public string $materials = '';
    public string $maker_name = '';
    public string $status = 'published';

    public $image;
    public ?string $existingImage = null;

    public array $categories = ['attire', 'regalia', 'craft', 'instrument', 'food'];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:'.implode(',', $this->categories)],
            'description' => ['nullable', 'string'],
            'significance' => ['nullable', 'string'],
            'materials' => ['nullable', 'string', 'max:255'],
            'maker_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:published,pending,draft'],
            'image' => ['nullable', 'image', 'max:4096'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $i = CulturalItem::findOrFail($id);
        $this->editingId = $i->id;
        $this->name = $i->name;
        $this->category = $i->category;
        $this->description = (string) $i->description;
        $this->significance = (string) $i->significance;
        $this->materials = (string) $i->materials;
        $this->maker_name = (string) $i->maker_name;
        $this->status = $i->status;
        $this->existingImage = $i->image_path;
        $this->image = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        $data = $this->validate();
        $payload = collect($data)->except('image')->toArray();

        if ($this->image) {
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $payload['image_path'] = $this->image->store('culture', 'public');
        }

        if ($this->editingId) {
            CulturalItem::findOrFail($this->editingId)->update($payload);
        } else {
            CulturalItem::create($payload);
        }

        $this->dispatch('notify', message: $this->editingId ? 'Item updated.' : 'Item added.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        $i = CulturalItem::findOrFail($id);
        if ($i->image_path) {
            Storage::disk('public')->delete($i->image_path);
        }
        $i->delete();
        $this->dispatch('notify', message: 'Item deleted.');
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'description', 'significance', 'materials', 'maker_name', 'image', 'existingImage']);
        $this->category = 'attire';
        $this->status = 'published';
        $this->resetValidation();
    }

    public function render()
    {
        $items = CulturalItem::orderBy('name')->get();

        return view('livewire.admin.cultural-item-manager', compact('items'));
    }
}
