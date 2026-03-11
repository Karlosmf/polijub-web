<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class SectionRenderer extends Component
{
    public $page;
    public $sections = [];

    protected $listeners = ['sectionUpdated' => 'loadSections'];

    public function mount($page = 'landing', $sections = null)
    {
        $this->page = $page;
        if ($sections !== null) {
            $this->sections = $sections;
        } else {
            $this->loadSections();
        }
    }

    public function loadSections()
    {
        // Solo cargar desde archivo si no estamos en un sub-renderizador (hijo)
        if ($this->page && !$this->sections_passed_manually()) {
            $path = storage_path("app/sections/{$this->page}.json");
            if (File::exists($path)) {
                clearstatcache(true, $path);
                $this->sections = json_decode(File::get($path), true) ?? [];
            }
        }
    }

    private function sections_passed_manually()
    {
        return count($this->sections) > 0 && !isset($this->page);
    }

    public function render()
    {
        return view('livewire.section-renderer');
    }
}
