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
                    <select name="is_publish" id="is_publish" class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm appearance-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="" selected>All Status</option>
                        <option value="0" {{ (request('is_publish') == 0 && request('is_publish') !== null) ? 'selected' : '' }}>Publish</option>
                        <option value="1" {{ (request('is_publish') == 1 && request('is_publish') !== null) ? 'selected' : '' }}>Un Publish</option>

                    </select>
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
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Code</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Investor Name</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Month / Year</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Capital</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Investor Assets</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Capital Gain/Loss</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Monthly Net Gain/Loss</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Fees</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Payment Distribution</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Monthly Net Percentage</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Number of Bonds</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Ending Balance</th>
                    <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($statistics as $stat)
                    <tr>
                        <td class="px-4 py-2 text-[11px] border border-gray-300">{{ $stat->investor_code }}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-nowrap">{{ $stat->user->name }}</td>
                        <td class="px-4 py-2 text-[11px] lowercase border border-gray-300 text-nowrap first-letter:capitalize">{{ ucfirst(substr($stat->month, 0, 3)) . " " . $stat->year}}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-end">{{ number_format($stat->capital, 2) }}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-end">{{ number_format($stat->investor_assets, 2) }}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-end {{ $stat->capital_gain_loss < 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($stat->capital_gain_loss, 2) }}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-end {{ $stat->monthly_net_gain_loss < 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($stat->monthly_net_gain_loss, 2) }}</td>
                        <td class="px-4 py-2 text-[11px] text-red-600 border border-gray-300 text-end">{{ number_format($stat->fees, 2) }}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-end {{ $stat->payment_distribution < 0 ? 'text-red-600' : '' }}">{{ number_format($stat->payment_distribution, 2) }}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-end {{ $stat->monthly_net_percentage < 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($stat->monthly_net_percentage, 2) }}%</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300">{{ $stat->number_of_bonds }}</td>
                        <td class="px-4 py-2 text-[11px] text-right border border-gray-300">{{ number_format($stat->ending_balance, 2) }}</td>
                        <td class="px-4 py-2 text-[11px] border border-gray-300 text-nowrap">

                            <button type="button" onclick="openDetailModal({{ $stat->id }})" class="inline-flex items-center px-3 py-1.5 text-[11px] text-white rounded-md transition-all duration-200 bg-blue-600 hover:bg-blue-700">
                                Details
                            </button>
                            @if ($stat->statement)
                                <form action="{{ route('admin.investments.generate', $stat->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-[11px] text-white rounded-md  transition-all duration-200 bg-capLionGold hover:bg-capLionGold/90">
                                        {{ __('Re-Generate') }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.investments.toggle-publish', $stat->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_publish" value="{{ $stat->is_publish ? 0 : 1 }}">
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-[11px] text-white rounded-md  transition-all duration-200 {{ $stat->is_publish ? 'bg-red-600 hover:bg-red-700' : 'bg-customBlue hover:bg-customBlue/90' }}">
                                        {{ __($stat->is_publish ? 'Unpublish' : 'Publish') }}
                                    </button>
                                </form>
                                <a href="{{ route('statements.show',$stat->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 text-[11px] text-white rounded-md  transition-all duration-200 bg-customBlue hover:bg-customBlue/90' }}">
                                    {{ 'Preview' }}
                                </a>
                                <a href="{{ route('statements.pdf',$stat->id) }}" class="inline-flex items-center px-3 py-1.5 text-[11px] text-white rounded-md  transition-all duration-200 bg-customGreen hover:bg-customBlue/90' }}">
                                    {{ 'Download' }}
                                </a>
                                <form action="{{ route('admin.investments.send-notification', $stat->user_id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-[11px] text-white rounded-md  transition-all duration-200 bg-customRed hover:bg-customRed/90">
                                        {{ __('Send Email') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.investments.generate', $stat->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-[11px] text-white rounded-md  transition-all duration-200 bg-capLionGold hover:bg-capLionGold/90">
                                        {{ __('Generate') }}
                                    </button>
                                </form>
                            @endif
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

    <!-- Modal Structure -->
    <div id="detail-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black opacity-50" onclick="closeDetailModal()"></div>
        <!-- Modal Content -->
        <div class="relative w-full max-w-6xl p-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Investment Transaction Details</h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal Table -->
            <div id="modal-content" class="overflow-x-auto">
                <!-- Table will be populated dynamically via JavaScript -->
            </div>
        </div>
    </div>
</div>
<!-- JavaScript for Modal -->
<script>
    function openDetailModal(statId) {
        // Fetch transaction details via AJAX
        fetch(`/admin/investments/${statId}/details`)
            .then(response => response.json())
            .then(data => {
                const modalContent = document.getElementById('modal-content');
                modalContent.innerHTML = `
                    <table class="min-w-full border border-collapse border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Investor Code</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Subaccount</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Investor Name</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Monthly Distribution</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Bond Series</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Amount</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Date</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Transaction</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Month</th>
                                <th class="px-4 py-2 text-[11px] text-left border border-gray-300">Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.transactions.map(transaction => `
                                <tr>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300">${transaction.investor_code}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300 text-nowrap">${transaction.investor_subaccount}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300 text-nowrap">${transaction.investor_name}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300">${(transaction.monthly_distribution ? 'YES' : 'NO')}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300">${transaction.bond_series}</td>
                                    <td class="px-4 py-2 text-[11px] text-right border border-gray-300 ${(parseFloat(transaction.amount) > 0) ? 'text-green-600' : 'text-red-600'}">${transaction.amount.toLocaleString('en-US', { minimumFractionDigits: 2 })}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300 text-nowrap">${transaction.date}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300 text-nowrap">${transaction.transaction}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300">${transaction.month}</td>
                                    <td class="px-4 py-2 text-[11px] border border-gray-300">${transaction.year}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
                document.getElementById('detail-modal').classList.remove('hidden');
            })
            .catch(error => console.error('Error fetching transaction details:', error));
    }

    function closeDetailModal() {
        document.getElementById('detail-modal').classList.add('hidden');
        document.getElementById('modal-content').innerHTML = '';
    }
</script>
