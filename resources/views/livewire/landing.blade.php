<div>
    <main class="container mx-auto">
        @livewire('section-renderer', ['page' => 'landing'])
        
        {{-- Aquí podrías seguir teniendo secciones fijas si lo deseas --}}
    </main>

    @push('scripts')
        <script src="{{ asset('js/subscription.js') }}"></script>
    @endpush
</div>
