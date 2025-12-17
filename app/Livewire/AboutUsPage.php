<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AboutUsPage extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.about-us-page');
    }
}
