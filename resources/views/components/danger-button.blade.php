<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-1.5 leading-7 bg-rose-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-700 focus:bg-rose-700 active:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
