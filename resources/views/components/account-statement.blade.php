<div class="relative max-w-4xl mx-auto bg-white">
    <!-- Main Content -->
    <div class="relative p-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Account Statement</h1>
            <img src="{{ asset('images/cap-lion-point-black.png') }}" alt="Cap Lion Point Logo" class="h-16">
        </div>

        <!-- Statement Info -->
        <div class="flex justify-between mb-6">
            <div class="flex items-stretch">
                <p class="text-[10px] text-gray-600">Statement #: <br/><span class="font-semibold text-gray-900 text-[12px]">{{ $statementData['statement_number'] ?? 'N/A' }} </span></p>
                <p class="px-8 text-[10px] text-gray-600">Date: <br/><span class="font-semibold text-gray-900 text-[12px]"> {{ date('d M Y',strtotime($statementData['date'])) ?? 'N/A' }} </span></p>
            </div>
        </div>

        <hr class="mb-6 border-[#000] text-gray-900">

        <!-- Customer Details -->
        <div class="flex justify-between mb-6">
            <div class="w-1/2">
                <p class="text-[10px] text-gray-600">Customer ID:<br><span class="text-[12px] font-bold text-gray-900">{{ $statementData['customer_id'] ?? 'N/A' }}</span></p>
                <p class="text-[10px] text-gray-600">Customer Name:<br><span class="text-[12px] font-bold text-gray-900">{{ $statementData['customer_name'] ?? 'N/A' }}</span></p>
                <p class="text-[10px] text-gray-600">Address:<br><span class="text-[12px] font-bold text-gray-900">{{ $statementData['address'] ?? 'N/A' }}</span></p>
            </div>
            <div class="w-1/2 p-4 border border-blue-900 bg-blue-50">
                <div class="grid grid-cols-[2fr_3fr] gap-x-2">
                    <!-- Labels Column (Aligned Right) -->
                    <div class="text-[10px] text-gray-600 text-right">
                        <p class="mb-3">Number of Bonds Subscribed:</p>
                        <p class="mb-3">Total Amount Subscribed (USD):</p>
                        <p class="mb-3">Bond Name:</p>
                        <p>Period / Distribution:</p>
                    </div>
                    <!-- Values Column (Aligned Left) -->
                    <div class="text-[12px] font-extrabold text-gray-900 text-left">
                        <p class="mb-2">{{ $statementData['bonds_subscribed'] ?? 'N/A' }}</p>
                        <p class="mb-2">{{ number_format($statementData['total_amount_subscribed'] ?? 0, 2) }}</p>
                        <p class="mb-2">{{ $statementData['bond_name'] ?? 'N/A' }}</p>
                        <p>{{ $statementData['period_distribution'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mb-6 border-[#000] text-gray-900">

        <!-- Account Summary -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-extrabold text-gray-900">Account Summary</h2>
                <p class="text-[10px] text-gray-500"><span class="font-semibold">Statement Period:</span> <br/> <span class="font-extrabold text-gray-900">{{ $statementData['statement_period'] ?? 'N/A' }}</span></p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-white bg-capLionBlue">
                            <th class="w-8 px-3 h-[3rem] py-1 text-sm font-semibold text-left border-b-4 border-capLionGold">#</th>
                            <th class="w-32 px-3 h-[3rem] py-1 text-sm font-semibold text-left border-b-4 border-capLionGold">Date</th>
                            <th class="px-3 h-[3rem] py-1 w-40 text-sm font-semibold text-left border-b-4 border-capLionGold">Description</th>
                            <th class="w-32 px-3 h-[3rem] py-1 text-sm font-semibold text-right border-b-4 border-capLionGold text-nowrap">Transaction (USD)</th>
                            <th class="w-32 px-3 h-[3rem] py-1 text-sm font-semibold text-right border-b-4 border-capLionGold">Balance (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @forelse ($statementData['transactions'] ?? [] as $index => $trans)
                            @foreach ($trans as $rowIndex => $transaction)
                                <tr class="{{ ($index == 'closing') ? 'bg-capLionBlue text-white' : (($loop->parent->index % 2 === 0) ? 'bg-white text-gray-900' : 'bg-gray-100 text-gray-900') }}">
                                    @if($rowIndex === 0)
                                        <td class="px-1 py-1 text-start align-top text-[10px] font-semibold h-[2rem]" rowspan="{{ count($trans) }}">
                                            {{ str_pad($loop->parent->index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-2 py-1 text-[10px] font-semibold h-[2rem] text-start align-top" rowspan="{{ count($trans) }}">
                                            {{ $transaction['date'] }}
                                        </td>
                                    @endif
                                    <td class="px-2 py-1 text-[10px] font-semibold h-[1rem] text-start align-top">
                                        {{ $transaction['transaction'] }}
                                    </td>
                                    <td class="px-2 py-1 text-[10px] font-semibold text-right h-[1rem] align-top {{ ($transaction['amount'] ?? 0) < 0 ? 'text-red-500' : '' }}">
                                        @if (isset($transaction['amount']) && $transaction['amount'] != 0)
                                            {{ number_format($transaction['amount'], 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-2 py-1 text-[10px] text-right font-semibold h-[1rem] align-top">
                                        @if (isset($transaction['balance']) && $transaction['balance'] != 0)
                                            {{ number_format($transaction['balance'], 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="px-2 py-1 text-center text-gray-500 border border-gray-300">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Performance Summary -->
        <div class="mb-6">
            <div class="p-4 border border-gray-900 w-80">
                <h2 class="mb-2 font-semibold text-gray-900 text-[12px]">Performance Summary</h2>
                <div class="flex justify-between">
                    <p class="text-[10px] text-gray-500">Gross Capital Gain <br/><span class="text-sm font-semibold text-gray-800">{{ number_format($statementData['gross_capital_gain'] ?? 0, 2) }}</span></p>
                    <p class="text-[10px] text-gray-500">Net Amount after fees<br/><span class="text-sm font-semibold text-gray-800">{{ number_format($statementData['net_amount'] ?? 0, 2) }}</span></p>
                </div>
            </div>
        </div>

        <!-- Disclaimer & Legal Notice -->
        <div class="mb-6">
            <h5 class="text-[12px] font-semibold text-gray-900">Disclaimer & Legal Notice</h5>
            <p class="text-[10px] italic text-gray-600">
                The information contained in this statement is provided for informational purposes only and does not constitute an offer to sell or a solicitation to buy any securities. Past performance is not indicative of future results. All investments carry risks, and you should review your statement carefully and consult with your financial advisor if needed.
            </p>
        </div>

        <!-- Footer -->
        <hr class="mb-4 border-t border-gray-900">
        <div class="text-gray-400">
            <div class="flex items-center justify-between">
                <div class="text-left">
                    <p class="font-semibold text-gray-900 text-[10px]">Cap Lion Point Ltd.</p>
                    <p class="text-[9px]">F02-04, Oceanic House Providence Estate P.O. Box 6038, Mahé, Seychelles</p>
                    <p class="text-[9px]">info@caplionpoint.com | +248 430 3187</p>
                </div>
                <div class="text-right text-[9px] text-gray-800">
                    <p>ACCOUNT STATEMENT | {{ date('d M Y',strtotime($statementData['date'])) ?? 'N/A' }} - {{ now()->format('H:i') }}</p>
                    <p>Page 1 of 1</p>
                </div>
            </div>
        </div>
    </div>
</div>
