<x-app-layout>
    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-20">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-semibold text-gray-900">Account Statement</h3>
                <a href="{{ route('admin.investment-list') }}" class="inline-flex items-center px-5 py-1.5 leading-7 bg-customBlue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-customBlue/90 focus:bg-customBlue/90 active:bg-customBlue/90 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition ease-in-out duration-200">
                    Back
                </a>
            </div>
            <x-account-statement :statementData="$statementData" />
        </div>
    </div>
</x-app-layout>
