<?php

namespace App\Livewire;

use Livewire\Component;

class MainCarousel extends Component
{
    public $id;
    public $slides = [];
    public $autoplay;
    public $delay;
    public $effect;
    public $show_dots;
    public $show_arrows;
    public $height;
    public $classes;

    public function mount(
        $id = 'main-carousel',
        $slides = '[]',
        $autoplay = true,
        $delay = 5000,
        $effect = 'slide',
        $show_dots = true,
        $show_arrows = true,
        $height = '70vh',
        $classes = ''
    ) {
        $this->id = $id;
        $this->slides = is_string($slides) ? json_decode($slides, true) : $slides;
        $this->autoplay = $autoplay;
        $this->delay = $delay;
        $this->effect = $effect;
        $this->show_dots = $show_dots;
        $this->show_arrows = $show_arrows;
        $this->height = $height;
        $this->classes = $classes;
    }

    public function render()
    {
        return view('livewire.main-carousel');
    }
}
