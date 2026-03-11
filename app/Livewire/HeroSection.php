<?php

namespace App\Livewire;

use Livewire\Volt\Component;

class HeroSection extends Component
{
    public $id;
    public $title;
    public $main_image;
    public $overlay_image;
    public $right_title;
    public $right_content;
    public $right_bg_color;
    public $cta_text;
    public $cta_link;
    public $classes;

    public function mount($id = 'hero', $title = '', $main_image = '', $overlay_image = '', $right_title = '', $right_content = '', $right_bg_color = '#DCD7CA', $cta_text = '', $cta_link = '#', $classes = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->main_image = $main_image;
        $this->overlay_image = $overlay_image;
        $this->right_title = $right_title;
        $this->right_content = $right_content;
        $this->right_bg_color = $right_bg_color;
        $this->cta_text = $cta_text;
        $this->cta_link = $cta_link;
        $this->classes = $classes;
    }

    public function render(): mixed
    {
        return view('livewire.hero-section');
    }
}
