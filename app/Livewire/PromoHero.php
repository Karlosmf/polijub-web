<?php

namespace App\Livewire;

use Livewire\Component;

class PromoHero extends Component
{
    public $id;
    public $title;
    public $description;
    public $subtitle;
    public $show_subtitle;
    public $button_text;
    public $button_url;
    public $show_button;
    public $image_path;
    public $title_color;
    public $subtitle_color;
    public $bg_color;
    public $content_alignment;
    public $vertical_alignment;
    public $overlays = [];
    public $classes;

    public function mount(
        $id = 'promo-hero',
        $title = '#LOQUEQUIERAS',
        $description = '',
        $subtitle = '',
        $show_subtitle = true,
        $button_text = 'Ver más',
        $button_url = '#',
        $show_button = true,
        $image_path = '',
        $title_color = '#fe0196',
        $subtitle_color = '#fe0196',
        $bg_color = '#DCD7CA',
        $content_alignment = 'justify-end',
        $vertical_alignment = 'items-center',
        $overlays = [],
        $classes = ''
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->subtitle = $subtitle;
        $this->show_subtitle = $show_subtitle;
        $this->button_text = $button_text;
        $this->button_url = $button_url;
        $this->show_button = $show_button;
        $this->image_path = $image_path;
        $this->title_color = $title_color;
        $this->subtitle_color = $subtitle_color;
        $this->bg_color = $bg_color;
        $this->content_alignment = $content_alignment;
        $this->vertical_alignment = $vertical_alignment;
        $this->overlays = is_string($overlays) ? json_decode($overlays, true) : $overlays;
        $this->classes = $classes;
    }

    public function render()
    {
        return view('livewire.promo-hero');
    }
}
