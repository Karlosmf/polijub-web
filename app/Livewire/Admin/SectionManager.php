<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class SectionManager extends Component
{
    use WithFileUploads;

    public $files = [];
    public $currentFile = null;
    public $sections = [];
    public $library = [];
    public $newFileName = '';
    
    // UI State
    public $showEditModal = false;
    public $editingPath = null;
    public $editingData = [];
    public $editingSchema = null;
    public $isCodeMode = false;
    public $rawJson = '';
    
    public $uploads = []; 

    public function mount()
    {
        $this->loadFiles();
        $this->loadLibrary();
    }

    public function loadLibrary()
    {
        $path = storage_path('app/component_library.json');
        if (File::exists($path)) {
            $this->library = json_decode(File::get($path), true) ?? [];
        }
    }

    public function loadFiles()
    {
        $path = storage_path('app/sections');
        if (!File::exists($path)) File::makeDirectory($path, 0755, true);
        $this->files = array_map(fn($f) => basename($f), File::files($path));
    }

    public function selectFile($filename)
    {
        $this->currentFile = $filename;
        $path = storage_path('app/sections/' . $filename);
        $this->sections = json_decode(File::get($path), true) ?? [];
    }

    public function save()
    {
        if (!$this->currentFile) return;
        $path = storage_path('app/sections/' . $this->currentFile);
        File::put($path, json_encode($this->sections, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->dispatch('sectionUpdated');
    }

    public function addComponent($componentName, $parentPath = null)
    {
        $schema = collect($this->library)->firstWhere('name', $componentName);
        if (!$schema) return;

        $newComponent = [
            'id' => $componentName . '-' . uniqid(),
            'component' => $componentName === 'container' ? 'container-component' : $componentName
        ];

        foreach ($schema['attributes'] as $attr) {
            $newComponent[$attr['name']] = $attr['default'];
        }

        if ($componentName === 'container') {
            $newComponent['children'] = [];
        }

        if ($parentPath === null) {
            $this->sections[] = $newComponent;
        } else {
            $this->setByPath($this->sections, $parentPath . ".children", array_merge($this->getByPath($this->sections, $parentPath . ".children") ?? [], [$newComponent]));
        }

        $this->save();
    }

    public function editComponent($path)
    {
        $this->editingPath = $path;
        $data = $this->getByPath($this->sections, $path);
        
        $libName = $data['component'] === 'container-component' ? 'container' : ($data['component'] === 'main-carousel' ? 'main-carousel' : $data['component']);
        $this->editingSchema = collect($this->library)->firstWhere('name', $libName);
        
        if ($this->editingSchema) {
            foreach ($this->editingSchema['attributes'] as $attr) {
                if (!isset($data[$attr['name']])) $data[$attr['name']] = $attr['default'] ?? '';
            }
        }

        $this->editingData = $data;
        $this->rawJson = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->isCodeMode = false;
        $this->uploads = []; 
        $this->showEditModal = true;
    }

    public function addToRepeater($fieldName)
    {
        if (!isset($this->editingData[$fieldName])) {
            $this->editingData[$fieldName] = [];
        }
        
        $attr = collect($this->editingSchema['attributes'])->firstWhere('name', $fieldName);
        $newEntry = [];
        foreach ($attr['fields'] as $field) {
            $newEntry[$field['name']] = $field['default'] ?? '';
        }
        
        $this->editingData[$fieldName][] = $newEntry;
    }

    public function removeFromRepeater($fieldName, $index)
    {
        unset($this->editingData[$fieldName][$index]);
        $this->editingData[$fieldName] = array_values($this->editingData[$fieldName]);
    }

    public function saveComponentEdits()
    {
        if ($this->isCodeMode) {
            $decoded = json_decode($this->rawJson, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                session()->flash('error', 'JSON Inválido.');
                return;
            }
            $this->editingData = $decoded;
        }

        // Procesar subidas de imágenes normales y en repetidores
        foreach ($this->uploads as $path => $file) {
            if ($file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('images/ui', $filename, 'public_custom');
                $this->setByPath($this->editingData, $path, 'images/ui/' . $filename);
            }
        }

        $this->setByPath($this->sections, $this->editingPath, $this->editingData);
        $this->save();
        $this->showEditModal = false;
    }

    public function deleteComponent($path)
    {
        $parts = explode('.', $path);
        $index = array_pop($parts);
        $parentPath = implode('.', $parts);
        
        if ($parentPath === "") {
            unset($this->sections[$index]);
            $this->sections = array_values($this->sections);
        } else {
            $childrenPath = str_replace('.children', '', $parentPath) . '.children';
            $children = $this->getByPath($this->sections, $childrenPath);
            unset($children[$index]);
            $this->setByPath($this->sections, $childrenPath, array_values($children));
        }
        $this->save();
    }

    public function duplicateComponent($path)
    {
        $copy = $this->getByPath($this->sections, $path);
        $copy['id'] = ($copy['component'] ?? 'comp') . '-' . uniqid();
        
        $parts = explode('.', $path);
        array_pop($parts);
        $parentPath = implode('.', $parts);

        if ($parentPath === "") {
            $this->sections[] = $copy;
        } else {
            $childrenPath = str_replace('.children', '', $parentPath) . '.children';
            $children = $this->getByPath($this->sections, $childrenPath);
            $children[] = $copy;
            $this->setByPath($this->sections, $childrenPath, $children);
        }
        $this->save();
    }

    private function getByPath($array, $path) { return data_get($array, $path); }
    private function setByPath(&$array, $path, $value) { data_set($array, $path, $value); }

    public function render()
    {
        return view('livewire.admin.section-manager')->layout('layouts.admin');
    }
}
