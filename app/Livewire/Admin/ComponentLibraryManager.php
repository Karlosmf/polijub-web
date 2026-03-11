<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class ComponentLibraryManager extends Component
{
    public $library = [];
    public $showModal = false;
    public $editingComponent = null;
    public $isCodeMode = false;
    public $rawJson = '';
    
    public $componentData = [
        'name' => '',
        'label' => '',
        'attributes' => []
    ];

    public function mount()
    {
        $this->loadLibrary();
    }

    public function loadLibrary()
    {
        $path = storage_path('app/component_library.json');
        if (File::exists($path)) {
            $this->library = json_decode(File::get($path), true) ?? [];
        }
    }

    public function saveLibrary()
    {
        $path = storage_path('app/component_library.json');
        File::put($path, json_encode($this->library, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        session()->flash('message', 'Librería actualizada.');
    }

    public function addComponent()
    {
        $this->reset(['componentData', 'rawJson', 'isCodeMode']);
        $this->componentData['attributes'] = [];
        $this->editingComponent = null;
        $this->showModal = true;
    }

    public function editComponent($index)
    {
        $this->editingComponent = $index;
        $this->componentData = $this->library[$index];
        $this->rawJson = json_encode($this->componentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->isCodeMode = false;
        $this->showModal = true;
    }

    public function updatedIsCodeMode($value)
    {
        if ($value) {
            $this->rawJson = json_encode($this->componentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            $decoded = json_decode($this->rawJson, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->componentData = $decoded;
            } else {
                $this->isCodeMode = true;
                session()->flash('error', 'JSON Inválido: ' . json_last_error_msg());
            }
        }
    }

    public function addAttribute()
    {
        $this->componentData['attributes'][] = [
            'name' => '',
            'label' => '',
            'type' => 'text',
            'default' => ''
        ];
    }

    public function removeAttribute($index)
    {
        unset($this->componentData['attributes'][$index]);
        $this->componentData['attributes'] = array_values($this->componentData['attributes']);
    }

    public function saveComponent()
    {
        if ($this->isCodeMode) {
            $decoded = json_decode($this->rawJson, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                session()->flash('error', 'No se puede guardar: JSON Inválido.');
                return;
            }
            $this->componentData = $decoded;
        }

        $this->validate([
            'componentData.name' => 'required|alpha_dash',
            'componentData.label' => 'required'
        ]);

        if ($this->editingComponent !== null) {
            $this->library[$this->editingComponent] = $this->componentData;
        } else {
            $this->library[] = $this->componentData;
        }

        $this->saveLibrary();
        $this->showModal = false;
    }

    public function deleteComponent($index)
    {
        unset($this->library[$index]);
        $this->library = array_values($this->library);
        $this->saveLibrary();
    }

    public function render()
    {
        return view('livewire.admin.component-library-manager')
            ->layout('layouts.admin');
    }
}
