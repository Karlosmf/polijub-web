<?php

namespace App\Livewire;

use Livewire\Component;

class NaturalSection extends Component
{
    public $id;
    public $title;
    public $content;
    public $bg_image;
    public $logo_image;
    public $button_text;
    public $button_url;
    public $classes;

    public function mount(
        $id = 'natural',
        $title = '100% NATURAL',
        $content = 'Nuestra materia prima principal, la leche, es de nuestra elaboración...',
        $bg_image = 'images/botella.webp',
        $logo_image = 'images/LOS_NENITOS.webp',
        $button_text = 'Establecimiento LOS NENITOS',
        $button_url = '/los-nenitos',
        $classes = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->bg_image = $bg_image;
        $this->logo_image = $logo_image;
        $this->button_text = $button_text;
        $this->button_url = $button_url;
        $this->classes = $classes;
    }

    public function render()
    {
        return view('livewire.natural-section');
    }
}
