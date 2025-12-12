<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

#[Layout('layouts.admin')]
class TagManager extends Component
{
    use WithPagination, Toast;

    public bool $myModal = false;
    public bool $isEditing = false;

    public $tagId;

    #[Rule('required|min:2|unique:tags,name,id')] // Name unique except for current ID
    public string $name = '';

    #[Rule('required')]
    public string $color = '#3E9B8A';

    public function mount()
    {
        if (request()->query('create')) {
            $this->create();
        }
    }

    public function save()
    {
        // Handle uniqueness validation manually for update to ignore current ID,
        // or use the rule string dynamic construction if simple attribute doesn't catch it.
        // The 'unique:tags,name,id' syntax in attribute might need 'ignore' context properly set or handled by Livewire intelligently.
        // Let's be explicit in validation call if needed, but Attribute should work if property is mapped.
        // Actually, for 'unique' rule with ID ignore, it's often safer to do standard validate() with custom rules method if ID is dynamic.
        // But let's try standard attribute first. If it fails on update, we fix.
        
        // Fix: Attribute rule 'unique:tags,name,id' attempts to look for 'id' column and ignore value of 'id' property? 
        // No, in standard Laravel validation 'unique:table,column,ignore_id'.
        // We can't easily pass $this->tagId to the attribute static definition.
        // So we override rules() method or use inline validate.
        
        $this->validate([
            'name' => 'required|min:2|unique:tags,name,' . $this->tagId,
            'color' => 'required',
        ]);

        $data = [
            'name' => $this->name,
            'color' => $this->color,
        ];

        if ($this->isEditing) {
            $tag = Tag::find($this->tagId);
            $tag->update($data);
            $this->success('Etiqueta actualizada correctamente.');
        } else {
            Tag::create($data);
            $this->success('Etiqueta creada correctamente.');
        }

        $this->myModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagId = $tag->id;
        $this->name = $tag->name;
        $this->color = $tag->color;
        
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
        Tag::destroy($id);
        $this->success('Etiqueta eliminada.');
    }

    public function resetForm()
    {
        $this->reset(['tagId', 'name', 'color']);
        $this->color = '#3E9B8A';
        $this->resetErrorBag();
    }

    public function render()
    {
        $tags = Tag::orderBy('name')
            ->paginate(10);

        return view('livewire.admin.tag-manager', [
            'tags' => $tags,
        ]);
    }
}