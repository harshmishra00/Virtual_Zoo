<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Animal;
use App\Models\Habitat;
use App\Models\Species;

class AnimalDirectory extends Component
{
    use WithPagination;

    public $search = '';
    public $habitat = '';
    public $class = '';
    public $status = '';
    public $diet = '';

    protected $queryString = [
        'search'  => ['except' => ''],
        'habitat' => ['except' => ''],
        'class'   => ['except' => ''],
        'status'  => ['except' => ''],
        'diet'    => ['except' => ''],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingHabitat() { $this->resetPage(); }
    public function updatingClass() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    public function updatingDiet() { $this->resetPage(); }

    public function clearFilters()
    {
        $this->reset(['search', 'habitat', 'class', 'status', 'diet']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Animal::with(['species', 'enclosure.habitat']);

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        if (!empty($this->habitat)) {
            $query->whereHas('enclosure.habitat', fn($q) => $q->where('id', $this->habitat));
        }
        if (!empty($this->class)) {
            $query->whereHas('species', fn($q) => $q->where('class', $this->class));
        }
        if (!empty($this->status)) {
            $query->where('conservation_status', $this->status);
        }
        if (!empty($this->diet)) {
            $query->where('diet', $this->diet);
        }

        $animals = $query->paginate(12);

        return view('livewire.animal-directory', [
            'animals' => $animals,
            'habitats' => Habitat::all(),
            'species' => Species::distinct('class')->get(['class']),
            'diets' => Animal::distinct('diet')->whereNotNull('diet')->pluck('diet'),
            'statuses' => ['Least Concern', 'Near Threatened', 'Vulnerable', 'Endangered', 'Critically Endangered', 'Extinct in Wild'],
        ]);
    }
}
