<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary']) }}>
    {{ $slot }}
</button>
