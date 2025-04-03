<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-1.5 leading-7 bg-customBlue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-customBlue/90 focus:bg-customBlue/90 active:bg-customBlue/90 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
