@props(['class' => ''])

@php
    $slides = [];
    if (Illuminate\Support\Facades\Storage::disk('public')->exists('carousel/slides.json')) {
        $json = Illuminate\Support\Facades\Storage::disk('public')->get('carousel/slides.json');
        $slidesData = json_decode($json, true);
        $slides = collect($slidesData)->map(function ($slide) {
            return [
                'image' => asset('storage/' . $slide['image_path']),
                'title' => $slide['title'],
                'description' => $slide['description'],
                'url' => $slide['url'],
                'urlText' => $slide['url_text'],
            ];
        })->toArray();
    }
@endphp

@if(count($slides) > 0)
    <x-carousel :slides="$slides" autoplay class="{{ $class }}" />
@endif
