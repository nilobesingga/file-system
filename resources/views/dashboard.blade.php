<x-app-layout>
    <div class="py-2">
        @if (Auth::user()->show_welcome_modal)
        <div id="welcomeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-lg">
            <div class="relative p-8 bg-white rounded-lg shadow-lg w-[400px]" onclick="event.stopPropagation()">
                <!-- Message Content -->
                <div class="max-w-xl p-6 mx-auto text-center text-yellow-800 border border-blue-200 rounded-md">
                    <h2 class="mb-2 text-xl font-semibold">🚧 Portal Under Construction</h2>
                    <p class="text-base">
                      Our portal is currently under construction and will be launching soon.<br>
                      We're working hard to bring you a better experience.
                    </p>
                    <p class="mt-4 text-sm">
                      📬 You’ll be notified as soon as it’s ready.<br>
                      <span class="font-medium">Thank you for your patience!</span>
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (Auth::user()->is_admin)
            <div class="mb-2 sm:w-1/3">
                <form id="investor-form" action="{{ route('dashboard') }}" method="get" x-data>
                    <select name="user_id" id="user_id"
                        class="block w-full p-2 border rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200"
                        @change="$el.form.submit()">
                        <option value="">Select Investor</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            @endif

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
                :netPerformance="$netPerformance"
                :netYield="$netYield"
                :hwlcd="$hwlcd"
                :hwlmd="$hwlmd"
            />
            <x-investment-widget :investorCode="$investor_code"/>
            <x-user-file-system-widget
                :totalFiles="$totalFiles"
                :unreadFilesCount="$newFiles"
                :recentUploadsCount="$recentUploadsCount"
            />
            <x-files-list :files="$files" :category="$category"/>
        </div>
    </div>
</x-app-layout>
