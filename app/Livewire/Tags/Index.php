<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

class Index extends Component
{
    use WithPagination, Toast;

    public bool $myModal = false;
    public bool $isEditing = false;
    public $tagId;

    #[Rule('required|min:2')]
    public string $name = '';

    #[Rule('required')]
    public string $color = '#3E9B8A';

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'color' => $this->color,
        ];

        if ($this->isEditing) {
            Tag::find($this->tagId)->update($data);
            $this->success('Etiqueta actualizada.');
        } else {
            Tag::create($data);
            $this->success('Etiqueta creada.');
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
        return view('livewire.tags.index', [
            'tags' => Tag::orderBy('name')->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'name', 'label' => 'Nombre'],
                ['key' => 'color', 'label' => 'Color'],
                ['key' => 'actions', 'label' => 'Acciones', 'class' => 'text-right']
            ]
        ]);
    }
}
