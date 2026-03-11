<?php

namespace App\Livewire;

use Livewire\Component;

class ContainerComponent extends Component
{
    public $id;
    public $display;
    public $classes;
    public $children = [];

    public function mount($id = 'container', $display = 'flex flex-col', $classes = 'p-4', $children = [])
    {
        $this->id = $id;
        $this->display = $display;
        $this->classes = $classes;
        $this->children = is_string($children) ? json_decode($children, true) : $children;
    }

    public function render()
    {
        return view('livewire.container-component');
    }
}
