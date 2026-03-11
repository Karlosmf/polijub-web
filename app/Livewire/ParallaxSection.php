<?php

namespace App\Livewire;

use Livewire\Component;

class ParallaxSection extends Component
{
    public $id;
    public $title;
    public $content;
    public $bg_image;
    public $top_image;
    public $button_text;
    public $button_url;
    public $classes;

    public function mount(
        $id = 'delivery',
        $title = 'DELIVERY:',
        $content = 'En tres pasos estás comiendo helado.',
        $bg_image = 'images/potehelado.webp',
        $top_image = 'images/milkdown.webp',
        $button_text = 'Hacé tu pedido YA mismo!',
        $button_url = '/shop',
        $classes = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->bg_image = $bg_image;
        $this->top_image = $top_image;
        $this->button_text = $button_text;
        $this->button_url = $button_url;
        $this->classes = $classes;
    }

    public function render()
    {
        return view('livewire.parallax-section');
    }
}
