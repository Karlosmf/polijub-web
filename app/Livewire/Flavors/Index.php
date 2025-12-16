<?php

namespace App\Livewire\Flavors;

use App\Models\Flavor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

class Index extends Component
{
    use WithPagination, Toast;

    public bool $myModal = false;
    public bool $isEditing = false;
    public $flavorId;

    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('nullable|string')]
    public string $color = '#ffffff';

    public bool $is_active = true;

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'color' => $this->color,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            Flavor::find($this->flavorId)->update($data);
            $this->success('Sabor actualizado correctamente.');
        } else {
            Flavor::create($data);
            $this->success('Sabor creado correctamente.');
        }

        $this->myModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $flavor = Flavor::findOrFail($id);
        $this->flavorId = $flavor->id;
        $this->name = $flavor->name;
        $this->color = $flavor->color ?? '#ffffff';
        $this->is_active = $flavor->is_active;
        
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
        $this->reset(['flavorId', 'name', 'color', 'is_active']);
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.flavors.index', [
            'flavors' => Flavor::orderBy('created_at', 'desc')->paginate(10),
            'headers' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'name', 'label' => 'Nombre'],
                ['key' => 'color', 'label' => 'Color'],
                ['key' => 'is_active', 'label' => 'Estado'],
                ['key' => 'actions', 'label' => 'Acciones', 'class' => 'text-right']
            ]
        ]);
    }
}
