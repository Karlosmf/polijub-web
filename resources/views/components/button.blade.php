<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary bg-brand-primary text-white font-bold py-2 px-4 rounded-lg shadow-md hover:bg-opacity-80 transition-all']) }}>
    {{ $slot }}
</button>