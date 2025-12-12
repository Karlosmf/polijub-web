<?php

namespace App\Livewire\Admin;

use App\Models\Flavor;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class FlavorManager extends Component
{
    use WithPagination, WithFileUploads, Toast;

    public bool $myModal = false;
    public bool $isEditing = false;

    // Form Fields
    public $flavorId;
    
    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('nullable|image|max:1024')] // 1MB Max
    public $image;
    public $existingImage;

    #[Rule('array')]
    public array $tags = []; // Selected Tag IDs

    public bool $is_active = true;

    // Search
    public string $search = '';

    public function mount()
    {
        if (request()->query('create')) {
            $this->create();
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        // Handle Image Upload
        if ($this->image) {
            $filename = $this->image->store('flavors', 'public'); 
            $data['image'] = $filename;
        }

        if ($this->isEditing) {
            $flavor = Flavor::find($this->flavorId);
            if (!$this->image) {
                unset($data['image']); 
            }
            $flavor->update($data);
            $flavor->tags()->sync($this->tags);
            $this->success('Sabor actualizado correctamente.');
        } else {
            if (!$this->image) {
                $data['image'] = 'images/default-flavor.webp'; // Fallback
            }
            $flavor = Flavor::create($data);
            $flavor->tags()->sync($this->tags);
            $this->success('Sabor creado correctamente.');
        }

        $this->myModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $flavor = Flavor::with('tags')->findOrFail($id);
        $this->flavorId = $flavor->id;
        $this->name = $flavor->name;
        $this->description = $flavor->description ?? '';
        $this->existingImage = $flavor->image;
        $this->is_active = $flavor->is_active;

        // Load existing tag IDs
        $this->tags = $flavor->tags->pluck('id')->toArray();
        
        $this->image = null;
        $this->isEditing = true;
        $this->myModal = true;
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->myModal = true;
    }

    public function delete($id)
    {
        Flavor::destroy($id);
        $this->success('Sabor eliminado.');
    }

    public function resetForm()
    {
        $this->reset(['flavorId', 'name', 'description', 'image', 'existingImage', 'tags', 'is_active']);
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        $flavors = Flavor::with('tags')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.flavor-manager', [
            'flavors' => $flavors,
            'availableTags' => Tag::orderBy('name')->get(),
        ]);
    }
}