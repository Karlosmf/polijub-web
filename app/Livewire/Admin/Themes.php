<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Themes & Widgets')]
class Themes extends Component
{
    public array $users = [
        ['id' => 1, 'name' => 'Mary Doe', 'email' => 'mary@example.com', 'role' => 'Admin'],
        ['id' => 2, 'name' => 'John Smith', 'email' => 'john@example.com', 'role' => 'User'],
        ['id' => 3, 'name' => 'Jane Wilson', 'email' => 'jane@example.com', 'role' => 'Editor'],
    ];

    public array $themes = [
        'system', 'light', 'dark', 'cupcake', 'bumblebee', 'emerald', 'corporate', 'synthwave', 'retro'
    ];

    public function render()
    {
        return view('livewire.admin.themes');
    }
}
