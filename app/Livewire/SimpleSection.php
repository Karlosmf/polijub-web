<?php

namespace App\Livewire;

use Livewire\Component;

class SimpleSection extends Component
{
    public $id;
    public $title;
    public $content;
    public $cta_text;
    public $cta_link;
    public $classes;
    public $title_classes = 'text-3xl font-bold mb-4';
    public $content_classes = 'max-w-3xl mx-auto mb-8 text-gray-600';

    public function mount($id = '', $title = '', $content = '', $cta_text = '', $cta_link = '#', $classes = '', $title_classes = null, $content_classes = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->cta_text = $cta_text;
        $this->cta_link = $cta_link;
        $this->classes = $classes;
        if ($title_classes) $this->title_classes = $title_classes;
        if ($content_classes) $this->content_classes = $content_classes;
    }

    public function render()
    {
        return view('livewire.simple-section');
    }
}
