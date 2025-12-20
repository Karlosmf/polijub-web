<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

class About extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.pages.about');
    }
}
