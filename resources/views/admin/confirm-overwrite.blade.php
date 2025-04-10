<x-app-layout>
    <div class="py-3">
        <div class="w-full mx-auto sm:px-6 lg:px-20">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-4 mb-6 text-yellow-800 border-l-4 border-yellow-500 rounded bg-yellow-50">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Duplicate records found in the database. Do you want to overwrite them?</span>
                        </div>
                    </div>

                    <!-- Display existing records -->
                    <div class="mb-6 overflow-x-auto">
                        <table class="min-w-full border border-collapse border-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border border-gray-300">Investor Code</th>
                                    <th class="px-4 py-2 border border-gray-300">Investor Sub-account</th>
                                    <th class="px-4 py-2 border border-gray-300">Investor Name</th>
                                    <th class="px-4 py-2 border border-gray-300">Monthly Distribution</th>
                                    <th class="px-4 py-2 border border-gray-300">Bond Series</th>
                                    <th class="px-4 py-2 border border-gray-300">Amount</th>
                                    <th class="px-4 py-2 border border-gray-300">Date</th>
                                    <th class="px-4 py-2 border border-gray-300">Transaction Type</th>
                                    <th class="px-4 py-2 border border-gray-300">Transaction</th>
                                    <th class="px-4 py-2 border border-gray-300">Year</th>
                                    <th class="px-4 py-2 border border-gray-300">Month</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($existing_records as $record)
                                    <tr>

                                        <td class="px-4 py-2 border border-gray-300">{{ $record['investor_code'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['investor_subaccount'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['investor_name'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['monthly_distribution'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['bond_series'] }}</td>
                                        <td class="px-4 py-2 text-right border border-gray-300">{{ number_format($record['amount'],2) }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['date'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['transaction_type'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['transaction'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['month'] }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $record['year'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Confirmation Form -->
                    <form action="{{ route('admin.investments.confirm-overwrite') }}" method="POST">
                        @csrf
                        <input type="hidden" name="overwrite" value="1">
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.investments.upload') }}" class="inline-flex items-center px-4 py-2 font-semibold text-white bg-gray-600 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 font-semibold text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Overwrite and Continue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
