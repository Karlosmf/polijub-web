<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DynamicPage extends Component
{
    public $slug;

    public function mount($slug = 'landing')
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return <<<'HTML'
            <div>
                @livewire('section-renderer', ['page' => $slug])
            </div>
        HTML;
    }
}
