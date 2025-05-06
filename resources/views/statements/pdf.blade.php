<!-- resources/views/statements/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Statement</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            color: #111827;
        }
        .statement-container {
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .statement-title {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .logo {
            height: 60px;
            position: absolute;
            right: 0;
            top: 0;
        }
        .statement-info {
            display: flex;
            margin-bottom: 15px;
        }
        .meta-item {
            font-size: 10px;
            color: #4B5563;
            margin-right: 40px;
        }
        .meta-value {
            font-size: 12px;
            font-weight: 600;
            color: #111827;
            display: block;
            margin-top: 2px;
        }
        .divider {
            border-top: 1px solid #111827;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .customer-section {
            display: block;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .customer-info {
            width: 43%;
        }
        .bond-info {
            position: absolute;
            right: 0;
            left: 42%;
            top: 110px;
            width: 55%;
            padding: 10px;
            border: 1px solid #003087;
            background-color: #EFF6FF;
        }
        .bond-grid {
            display: table;
            width: 100%;
        }
        .bond-row {
            display: table-row;
        }
        .bond-label {
            display: table-cell;
            font-size: 10px;
            color: #4B5563;
            text-align: right;
            padding-right: 10px;
            padding-bottom: 8px;
            width: 41%;
        }
        .bond-value {
            display: table-cell;
            font-size: 12px;
            font-weight: 700;
            color: #111827;
            text-align: left;
            padding-bottom: 10px;
            /* width: 50%; */
        }
        .info-label {
            font-size: 10px;
            color: #4B5563;
            margin-bottom: 2px;
            margin-top: 0;
        }
        .info-value {
            font-size: 12px;
            font-weight: 700;
            color: #111827;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            align-items: flex-end;
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        .period-label {
            font-size: 10px;
            color: #6B7280;
            text-align: right;
            margin-right: 0;
            margin-top: -20px;
        }
        .period-value {
            font-size: 10px;
            font-weight: 600;
            color: #111827;
        }
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        .transactions-table th {
            background-color: #091935;
            color: white;
            font-size: 12px;
            font-weight: 600;
            text-align: left;
            padding: 10px;
            border-bottom: 4px solid #A57D2D;
        }
        .transactions-table th:nth-child(4),
        .transactions-table th:nth-child(5) {
            text-align: right;
        }
        .transactions-table td {
            padding: 8px;
            font-size: 10px;
            font-weight: 500;
            vertical-align: top;
            /* height: 20px; */
        }
        .transactions-table td:nth-child(4),
        .transactions-table td:nth-child(5) {
            text-align: right;
        }
        .transactions-table tr:nth-child(even) {
            /* background-color: #F3F4F6; */
        }
        .performance-box {
            width: 300px;
            padding: 10px;
            border: 1px solid #111827;
            margin-bottom: 20px;
        }
        .performance-title {
            font-size: 12px;
            font-weight: 600;
            color: #111827;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .performance-flex {
            display: flex;
            justify-content: space-between;
        }
        .performance-label {
            font-size: 10px;
            color: #6B7280;
            margin: 0;
        }
        .performance-value {
            font-size: 14px;
            font-weight: 600;
            color: #1F2937;
            display: block;
            margin-top: 3px;
        }
        .disclaimer-title {
            font-size: 11px;
            font-weight: 600;
            font-style: italic;
            color: #111827;
            margin-bottom: 5px;
            margin-top: 0;
        }
        .disclaimer-text {
            font-size: 10px;
            font-style: italic;
            color: #4B5563;
            margin-bottom: 20px;
            margin-top: 0;
        }
        .footer-container {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #4B5563;
        }
        .footer-company {
            font-size: 10px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 2px;
            margin-top: 0;
        }
        .footer-address {
            margin: 0;
            margin-bottom: 2px;
        }
        .footer-right {
            text-align: right;
            color: #1F2937;
        }
        .footer-right p {
            margin: 0;
            margin-bottom: 2px;
        }
        .bg-capLionBlue {
            background-color: #091935 !important;
            color : white !important;
            text-color : #fff;
        }
    </style>
</head>
<body>
    <div class="statement-container">
        <!-- Header -->
        <div class="header">
            <h1 class="statement-title">Account Statement</h1>
            <img src="{{ $logo }}" alt="Cap Lion Point Logo" class="logo">
        </div>

        <!-- Statement Info -->
        <div class="statement-info">
            <div class="meta-item">
                Statement #: <span class="meta-value">{{ $statementData['statement_number'] }}</span>
            </div>
            <div class="meta-item" style="position: absolute; left : 18%; top: 50px;">
                Date: <span class="meta-value">{{ date('d M Y', strtotime($statementData['date'])) }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Customer Details -->
        <div class="customer-section">
            <div class="customer-info">
                <p class="info-label">Customer ID:</p>
                <p class="info-value">{{ $statementData['customer_id'] }}</p>
                <p class="info-label">Customer Name:</p>
                <p class="info-value">{{ $statementData['customer_name'] }}</p>
                <p class="info-label">Address:</p>
                <p class="info-value">{{ $statementData['address'] }}</p>
            </div>
            <div class="bond-info">
                <div class="bond-grid">
                    <div class="bond-row">
                        <div class="bond-label">Number of Bonds Subscribed:</div>
                        <div class="bond-value">{{ $statementData['bonds_subscribed'] }}</div>
                    </div>
                    <div class="bond-row">
                        <div class="bond-label">Total Amount Subscribed (USD):</div>
                        <div class="bond-value">{{ number_format($statementData['total_amount_subscribed'], 2) }}</div>
                    </div>
                    <div class="bond-row">
                        <div class="bond-label">Bond Name:</div>
                        <div class="bond-value">{{ $statementData['bond_name'] }}</div>
                    </div>
                    <div class="bond-row">
                        <div class="bond-label">Period:</div>
                        <div class="bond-value">{{ $statementData['period_distribution'] }}</div>
                    </div>
                    <div class="bond-row">
                        <div class="bond-label">Monthly Distribution:</div>
                        <div class="bond-value">{{ $statementData['monthly_distribution'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Account Summary -->
        <div>
            <div class="section-header">
                <h2 class="section-title">Account Summary</h2>
                <p class="period-label">Statement Period: &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;<br><span class="period-value">{{ $statementData['statement_period'] }}</span></p>
            </div>
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th style="width: 100px;">Date</th>
                        <th>Description</th>
                        <th style="width: 120px;">Transaction (USD)</th>
                        <th style="width: 120px;">Balance (USD)</th>
                        <th style="width: 120px;">Explanation</th>
                    </tr>
                </thead>
                <tbody>
                      @php $i = 1; @endphp
                        @forelse ($statementData['transactions'] ?? [] as $index => $trans)
                            @foreach ($trans as $rowIndex => $transaction)
                                <tr style="{{ ($index == 'closing') ? 'background-color: #091935 !important; color: #fff !important;' : ($loop->parent->iteration % 2 == 0 ? 'background-color: #F3F4F6;' : '') }} color: #111827;">
                                    @if($rowIndex === 0)
                                        <td rowspan="{{ count($trans) }}">
                                            {{ str_pad($loop->parent->index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td rowspan="{{ count($trans) }}">
                                            {{ $transaction['date'] }}
                                        </td>
                                    @endif
                                    <td style="height: 15px !important;">
                                        {{ $transaction['transaction'] }}
                                    </td>
                                    <td style="height: 15px !important; text-align: right !important; {{ isset($transaction['amount']) && $transaction['amount'] < 0 ? 'color: red;' : '' }}">
                                        @if (isset($transaction['amount']) && $transaction['amount'] != 0)
                                            {{ number_format($transaction['amount'], 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="height: 15px !important; text-align: right !important;">
                                        @if (isset($transaction['balance']) && $transaction['balance'] != 0)
                                            {{ number_format($transaction['balance'], 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="height: 15px !important; text-align: left !important;">
                                        @if (isset($transaction['explanation']) && $transaction['explanation'] != '')
                                            {{ $transaction['explanation'] }}
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
        <div class="footer-container">
        <!-- Performance Summary -->
        <div class="performance-box">
            <h3 class="performance-title">Performance Summary</h3>
            <div class="performance-flex">
                <div>
                    <p class="performance-label">
                        Gross Capital Gain
                        <span class="performance-value">{{ number_format($statementData['gross_capital_gain'], 2) }}</span>
                    </p>
                </div>
                <div>
                    <p class="performance-label" style="text-align: right; margin-right: 20px; margin-top: -32px; margin-bottom: 5px;">
                        Net Amount after fees
                        <span class="performance-value" style="margin-left: -40px !important;">{{ number_format($statementData['net_amount'], 2) }} &nbsp; &nbsp;&nbsp; &nbsp;</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- Disclaimer & Legal Notice -->
        <div>
            <h4 class="disclaimer-title">Disclaimer & Legal Notice:</h4>
            <p class="disclaimer-text">
                The information contained in this statement is provided for informational purposes only
                and does not constitute an offer to sell or a solicitation to buy any securities. Past
                performance is not indicative of future results. All investments carry risks, and you should
                review your statement carefully and consult with your financial advisor if needed.
            </p>
        </div>

        <!-- Footer -->
            <div class="divider"></div>
            <div class="footer">
                <div>
                    <p class="footer-company">Cap Lion Point Ltd.</p>
                    <p class="footer-address">F02-04, Oceanic House Providence Estate P.O. Box 6038, Mahé, Seychelles</p>
                    <p class="footer-address">info@caplionpoint.com | +248 430 3187</p>
                </div>
                <div class="footer-right">
                    <p>ACCOUNT STATEMENT | {{ date('d M Y', strtotime($statementData['date'])) }} - {{ now()->format('H:i') }}</p>
                    <p>Page 1 of 1</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
