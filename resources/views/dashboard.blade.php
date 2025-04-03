<x-app-layout>
    <div class="py-2">
        @if (session('show_welcome_modal') && Auth::user()->show_welcome_modal)
        <div id="welcomeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-lg">
            <div class="relative p-8 bg-white rounded-lg shadow-lg w-[400px]" onclick="event.stopPropagation()">
                <!-- Banner Header -->
                <div class="flex items-center px-4 py-3 bg-blue-100 border-l-4 border-blue-500 rounded-md">
                    <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"/>
                    </svg>
                    <h2 class="ml-3 text-xl font-semibold text-blue-800">Welcome to our New Portal</h2>
                </div>

                <!-- Message Content -->
                <div class="mt-4 text-gray-700">
                    <p>Your login was successful!</p>
                    <p class="mt-2">
                        The first set of data will be uploaded by <strong>Saturday, April 5</strong>.
                        Please visit us again at the end of the week. Thank you!
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-dashboard-widget
                :recentUploadsCount="$recentUploadsCount"
                :totalFiles="$totalFiles"
                :amountInvested="$amountInvested"
                :currency="$currency"
                :numberOfBonds="$numberOfBonds"
                :monthlyInvestments="$monthlyInvestments"
                :monthlyBonds="$monthlyBonds"
                :labels="$labels"
                :newFiles="$newFiles"
            />
            <x-files-list :files="$files" :category="$category"/>
        </div>
    </div>
</x-app-layout>
