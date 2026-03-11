<?php

namespace App\Livewire;

use Livewire\Component;

class FlavorsSection extends Component
{
    public $id;
    public $title;
    public $content;
    public $bg_image;
    public $overlay_image;
    public $button_text;
    public $button_url;
    public $classes;

    public function mount(
        $id = 'sabores',
        $title = 'SABORES...',
        $content = 'Siempre es un buen momento para descubrir nuestros nuevos sabores...',
        $bg_image = 'images/helados.webp',
        $overlay_image = 'images/milkup.webp',
        $button_text = 'Conocelos todos',
        $button_url = '/shop',
        $classes = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->bg_image = $bg_image;
        $this->overlay_image = $overlay_image;
        $this->button_text = $button_text;
        $this->button_url = $button_url;
        $this->classes = $classes;
    }

    public function render()
    {
        return view('livewire.flavors-section');
    }
}
