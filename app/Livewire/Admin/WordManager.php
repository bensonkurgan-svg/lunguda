<?php

namespace App\Livewire\Admin;

use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Words')]
class WordManager extends Component
{
    use WithFileUploads, WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public bool $showForm = false;
    public ?int $editingId = null;

    // Form fields
    public string $word = '';
    public string $dialect = 'Guyuk';
    public string $part_of_speech = '';
    public string $meaning = '';
    public string $ipa = '';
    public string $example_sentence = '';
    public string $example_translation = '';
    public string $recorded_by_name = '';
    public bool $consent_given = false;
    public string $status = 'published';

    public $audio;          // newly uploaded file
    public ?string $existingAudio = null;

    public array $dialects = ['Cerin', 'Deele', 'Guyuk', 'Gwaanda', 'Kɔla'];

    protected function rules(): array
    {
        return [
            'word' => ['required', 'string', 'max:255'],
            'dialect' => ['required', 'in:'.implode(',', $this->dialects)],
            'part_of_speech' => ['nullable', 'string', 'max:80'],
            'meaning' => ['required', 'string'],
            'ipa' => ['nullable', 'string', 'max:255'],
            'example_sentence' => ['nullable', 'string'],
            'example_translation' => ['nullable', 'string'],
            'recorded_by_name' => ['nullable', 'string', 'max:255'],
            'consent_given' => ['boolean'],
            'status' => ['required', 'in:published,pending,draft'],
            // Audio: max 8 MB, common web-audio mime types only.
            'audio' => ['nullable', 'file', 'max:8192', 'mimes:mp3,wav,ogg,m4a,aac,webm'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $w = Word::findOrFail($id);
        $this->editingId = $w->id;
        $this->word = $w->word;
        $this->dialect = $w->dialect;
        $this->part_of_speech = (string) $w->part_of_speech;
        $this->meaning = $w->meaning;
        $this->ipa = (string) $w->ipa;
        $this->example_sentence = (string) $w->example_sentence;
        $this->example_translation = (string) $w->example_translation;
        $this->recorded_by_name = (string) $w->recorded_by_name;
        $this->consent_given = (bool) $w->consent_given;
        $this->status = $w->status;
        $this->existingAudio = $w->audio_path;
        $this->audio = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        $payload = collect($data)->except('audio')->toArray();

        // Store audio on the public disk with a random, non-guessable name.
        if ($this->audio) {
            if ($this->existingAudio) {
                Storage::disk('public')->delete($this->existingAudio);
            }
            $payload['audio_path'] = $this->audio->store('audio/words', 'public');
        }

        if ($this->editingId) {
            $word = Word::findOrFail($this->editingId);
            $word->update($payload);
        } else {
            $payload['contributed_by'] = Auth::id();
            $payload['approved_by'] = Auth::id();
            Word::create($payload);
        }

        $this->dispatch('notify', message: $this->editingId ? 'Word updated.' : 'Word added.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        $word = Word::findOrFail($id);
        if ($word->audio_path) {
            Storage::disk('public')->delete($word->audio_path);
        }
        $word->delete();
        $this->dispatch('notify', message: 'Word deleted.');
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editingId', 'word', 'part_of_speech', 'meaning', 'ipa',
            'example_sentence', 'example_translation', 'recorded_by_name',
            'consent_given', 'audio', 'existingAudio',
        ]);
        $this->dialect = 'Guyuk';
        $this->status = 'published';
        $this->resetValidation();
    }

    public function render()
    {
        $words = Word::query()
            ->when($this->search, fn ($q) => $q->where('word', 'like', "%{$this->search}%")->orWhere('meaning', 'like', "%{$this->search}%"))
            ->orderByDesc('id')->paginate(10);

        return view('livewire.admin.word-manager', compact('words'));
    }
}
