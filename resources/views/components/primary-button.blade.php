<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-blue border border-blue rounded-xl font-semibold text-xs text-white hover:bg-blue-hover focus:bg-blue active:bg-blue focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 h-11']) }}>
    {{ $slot }}
</button>
