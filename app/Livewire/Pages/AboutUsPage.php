<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AboutUsPage extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('livewire.pages.about-us-page');
    }
}
