<div class="p-6 bg-white rounded-lg shadow-md">
    <h3 class="mb-4 text-lg font-semibold text-gray-900">Investment Record</h3>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.investment-list') }}" class="p-6 mb-6 rounded-lg shadow-sm bg-gray-50">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Investor Code -->
            <div>
                <label for="investor_code" class="block mb-1 text-sm font-medium text-gray-700">Investor Code</label>
                <input type="text" name="investor_code" id="investor_code" value="{{ request('investor_code') }}" class="block w-full px-3 py-2 placeholder-gray-400 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter code">
            </div>

            <!-- Investor Name -->
            <div>
                <label for="investor_name" class="block mb-1 text-sm font-medium text-gray-700">Investor Name</label>
                <input type="text" name="investor_name" id="investor_name" value="{{ request('investor_name') }}" class="block w-full px-3 py-2 placeholder-gray-400 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter name">
            </div>
            <!-- Select Investor -->
            <div>
                <label for="selected_investor" class="block mb-1 text-sm font-medium text-gray-700">Select Investor</label>
                <div class="relative">
                    <select name="selected_investor" id="selected_investor" class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Investors</option>
                        @foreach ($investors as $investor)
                            <option value="{{ $investor->name }}" {{ request('selected_investor') == $investor->name ? 'selected' : '' }}>{{ $investor->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Month -->
            <div>
                <label for="month" class="block mb-1 text-sm font-medium text-gray-700">Months</label>
                <x-multi-select
                    name="month[]"
                    id="month"
                    :selections="$months"
                    :selected="request('month', [])"
                    placeholder="Select months"
                />
            </div>
            <!-- Year -->
            <div>
                <label for="year" class="block mb-1 text-sm font-medium text-gray-700">Year</label>
                <div class="relative">
                    <select name="year" id="year" class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Years</option>
                        @foreach (range(date('Y'), date('Y') - 1) as $y)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Buttons -->
            <div>
                <label for="year" class="block mb-1 text-sm font-medium text-gray-700">Filter</label>
                <div class="relative flex justify-start space-x-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.investment-list') }}" class="inline-flex items-center px-4 py-2 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                </div>
            </div>
        </div>
    </form>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="p-4 mb-6 text-green-800 border-l-4 border-green-500 rounded bg-green-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 mb-6 text-red-800 border-l-4 border-red-500 rounded bg-red-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-collapse border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border border-gray-300">Code</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Investor Name</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Month / Year</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Capital</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Investor Assets</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Capital Gain/Loss</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Monthly Net Gain/Loss</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Fees</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Payment Distribution</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Monthly Net Percentage</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Number of Bonds</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Ending Balance</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($statistics as $stat)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $stat->investor_code }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300 text-nowrap">{{ $stat->user->name }}</td>
                        <td class="px-4 py-2 lowercase border border-gray-300 text-nowrap first-letter:capitalize">{{ ucfirst(substr($stat->month, 0, 3)) . " " . $stat->year}}</td>
                        <td class="px-4 py-2 border border-gray-300 text-end">{{ number_format($stat->capital, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-end">{{ number_format($stat->investor_assets, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-end {{ $stat->capital_gain_loss < 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($stat->capital_gain_loss, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-end {{ $stat->monthly_net_gain_loss < 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($stat->monthly_net_gain_loss, 2) }}</td>
                        <td class="px-4 py-2 text-red-600 border border-gray-300 text-end">{{ number_format($stat->fees, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-end {{ $stat->payment_distribution < 0 ? 'text-red-600' : '' }}">{{ number_format($stat->payment_distribution, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-end {{ $stat->monthly_net_percentage < 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($stat->monthly_net_percentage, 2) }}%</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $stat->number_of_bonds }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ number_format($stat->ending_balance, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <form action="{{ route('admin.investments.toggle-publish', $stat->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_publish" value="{{ $stat->is_publish ? 0 : 1 }}">
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm text-white rounded-md  transition-all duration-200 {{ $stat->is_publish ? 'bg-red-600 hover:bg-red-700' : 'bg-customBlue hover:bg-customBlue/90' }}">
                                    {{ __($stat->is_publish ? 'Unpublish' : 'Publish') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="px-4 py-2 text-center text-gray-500 border border-gray-300">
                            No investment statistics found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $statistics->links() }}
    </div>
</div>
