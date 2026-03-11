<section id="{{ $id }}" class="{{ $classes }}">
    @if($title)
        <h2 class="{{ $title_classes }}">{{ $title }}</h2>
    @endif

    @if($content)
        <p class="{{ $content_classes }}">
            {!! nl2br(e($content)) !!}
        </p>
    @endif

    @if($cta_text)
        <a href="{{ $cta_link }}" class="btn-polijub-primary">
            {{ $cta_text }}
        </a>
    @endif
</section>
