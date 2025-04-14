<?php

namespace App\Http\Controllers;

use App\Imports\InvestorTransactionsImport;
use App\Models\Investment;
use App\Models\InvestmentStatistic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
class InvestementController extends Controller
{
    public function index()
    {
        $investments = Investment::with('user')->latest()->paginate(15);
        $users = User::select('id', 'name')->get();
        return view('admin.investment', compact('investments', 'users'));
    }

    public function investementList()
    {
        $investments = InvestmentStatistic::with('user')->latest()->paginate(15);
        $users = User::select('id', 'name')->get();
        return view('admin.investment-list', compact('investments', 'users'));
    }

    public function togglePublish(Request $request, $id)
    {
        try {
            $statistic = InvestmentStatistic::find($id);
            if (!$statistic) {
                return redirect()->route('admin.investment-list')->with('error', 'Investment statistic not found.');
            }
            $statistic->update([
                'is_publish' => ($statistic->is_publish == false) ? 1 : 0,
            ]);
            return redirect()->route('admin.investment-list')->with('success', 'Publish status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.investment-list')->with('error', 'Error updating publish status: ' . $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx',
            'file.*' => 'max:10000', // Validate each file
        ]);

        try {
            // Import the file into investor_transactions
            $file = $request->file('file');
            $fileData = FacadesExcel::toArray(new \App\Imports\InvestorTransactionsImport, $file);
            // Check if the file has data
            if (empty($fileData) || empty($fileData[0])) {
                return redirect()->route('admin.investments')->with('error', 'The uploaded file is empty.');
            }
            // Define required headers
            $requiredHeaders = [
                "investor_code",
                "investor_sub_account",
                "investor_name",
                "monthly_distribution",
                "bond_serie",
                "amount",
                "date",
                "transaction_type",
                "transaction",
                "month",
                "year",
                "explanation"
            ];

            // Extract headers from the first row
            $sheetData = $fileData[0]; // First sheet
            $headers = array_keys($sheetData[0]); // Get the keys (headers) from the first row

            // Normalize headers (convert to lowercase, trim spaces)
            $normalizedHeaders = array_map(function ($header) {
                return strtolower(trim($header));
            }, $headers);

            // Check for required headers
            $missingHeaders = [];
            foreach ($requiredHeaders as $requiredHeader) {
                if (!in_array($requiredHeader, $normalizedHeaders)) {
                    // Special case for 'investor_subaccount' (also check for 'investor_sub_account')
                    if ($requiredHeader === 'investor_subaccount' && in_array('investor_sub_account', $normalizedHeaders)) {
                        continue; // Accept 'investor_sub_account' as a valid alternative
                    }
                    $missingHeaders[] = $requiredHeader;
                }
            }

            // If any required headers are missing, return an error
            if (!empty($missingHeaders)) {
                $missingList = implode(', ', $missingHeaders);
                return redirect()->route('admin.investments')->with('error', "The uploaded file is missing the following required columns: {$missingList}.");
            }
            $folderPath = 'investor/investment/' . Auth::user()->id . '/';
            $file->store($folderPath, 'public');

            // Check for existing records
            $existingRecords = [];
            $sheetData = $fileData[0]; // First sheet
            // Extract unique investor codes from the file
            $investorCodes = collect($sheetData)
            ->pluck('investor_code')
            ->filter() // Remove null values
            ->unique()
            ->values()
            ->toArray();

            foreach ($sheetData as $row) {
                $investorCode = $row['investor_code'] ?? null;
                $investorSubaccount = $row['investor_subaccount'] ?? $row['investor_sub_account'] ?? null;
                $monthlyDistribution = $row['monthly_distribution'] ?? null;
                $transactionType = $row['transaction_type'] ?? null;
                $month = $row['month'] ?? null;
                $year = $row['year'] ?? null;
                $bond_series = $row['bond_serie'] ?? null;
                $amount = $row['amount'] ?? null;
                $investor_name = $row['investor_name'] ?? null;
                $date = $this->parseDate($row['date']) ?? null;
                $transaction = $row['transaction'] ?? null;

                // Skip if any required field is missing
                if (!$investorCode || !$investorSubaccount || !$monthlyDistribution || !$transactionType || !$month || !$year) {
                    continue;
                }

                // Check if a record with these values already exists
                $exists = Investment::where('investor_code', $investorCode)
                    ->where('investor_subaccount', $investorSubaccount)
                    ->where('monthly_distribution', $this->parseMonthlyDistribution($monthlyDistribution))
                    ->where('transaction_type', $transactionType)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->exists();

                if ($exists) {
                    $existingRecords[] = [
                        'investor_code' => $investorCode,
                        'investor_subaccount' => $investorSubaccount,
                        'monthly_distribution' => $monthlyDistribution,
                        'transaction_type' => $transactionType,
                        'month' => $month,
                        'investor_name' => $investor_name,
                        'year' => $year,
                        'bond_series' => $bond_series,
                        'amount' => $amount,
                        'date' => $date,
                        'transaction' => $transaction
                    ];
                }
            }

            // If existing records are found, redirect to confirmation view
            if (!empty($existingRecords)) {
                // Store the file in the session temporarily
                $request->session()->put('pending_upload_file', $file->store('temp'));
                $request->session()->put('investor_codes', $investorCodes);
                return view('admin.confirm-overwrite', [
                    'existing_records' => $existingRecords,
                ]);
            }
            FacadesExcel::import(new InvestorTransactionsImport, $request->file('file'));
            // Calculate monthly statistics
            $this->calculateMonthlyStatistics($investorCodes);

            return redirect()->route('admin.investments')->with('success', 'File uploaded and statistics updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.investments')->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    private function calculateMonthlyStatistics(array $investorCodes)
    {
        // Loop through each investor code
        foreach ($investorCodes as $investorCode) {
            // Fetch the user
            $user = User::where('code', $investorCode)->first();
            if (!$user) {
                throw new \Exception('User with code '.$investorCode.' not found.');
            }

            // Fetch all transactions for the investor, ordered chronologically
            $transactions = Investment::where('investor_code', $investorCode)
                ->orderBy('date') // Ensure chronological order for cumulative calculations
                ->get()
                ->groupBy('year')
                ->map(function ($yearGroup) {
                    return $yearGroup->groupBy('month');
                });

            // Initialize cumulative values
            $cumulativeBalance = 0; // For ending_balance
            $cumulativeBonds = 0;   // For ending_bond
            $cumulativeCapital = 0;    // For fees
            // Loop through each year and month
            foreach ($transactions as $year => $months) {
                foreach ($months as $month => $monthTransactions) {
                    // Calculate monthly metrics
                    $monthlyCapital = $monthTransactions->where('transaction_type', Investment::TRANSACTION_TYPE_CAPITAL_DEPOSIT_WITHDRAW)->sum('amount');
                    $monthlyCapitalGainLoss = $monthTransactions->where('transaction_type', Investment::TRANSACTION_TYPE_CAPITAL_GAIN_LOSS)->sum('amount');
                    $monthlyNetGainLoss = $monthTransactions->whereIn('transaction_type', [
                        Investment::TRANSACTION_TYPE_CAPITAL_GAIN_LOSS,
                        Investment::TRANSACTION_TYPE_SUCCESS_FEE,
                    ])->sum('amount');
                    $monthlyFees = $monthTransactions->where('transaction_type', Investment::TRANSACTION_TYPE_SUCCESS_FEE)->sum('amount');
                    $paidCustodianDistribution = $monthTransactions->where('transaction_type', Investment::TRANSACTION_TYPE_PAID_CUSTODIAN_DISTRIBUTION)->sum('amount');

                    // Calculate bond changes for this month
                    $bondChanges = $monthTransactions->where('transaction_type', Investment::TRANSACTION_TYPE_CAPITAL_DEPOSIT_WITHDRAW)
                        ->map(function ($transaction) {
                            // Assume $10,000 per bond
                            return (int) ($transaction->amount / 10000);
                        })->sum();
                    $cumulativeBonds += $bondChanges;
                    // Calculate other metrics
                    $investorAssets = $monthTransactions->sum('amount'); // Total transactions for the month
                    $cumulativeBalance += $investorAssets; // Update cumulative balance with total transactions

                    $cumulativeCapital += $monthlyCapital;
                    $numberOfBonds = $cumulativeCapital / 10000;
                    $monthlyNetPercentage = $cumulativeCapital ? ($monthlyNetGainLoss / $cumulativeCapital) * 100 : 0;

                    // Update or create the monthly statistic
                    InvestmentStatistic::updateOrCreate(
                        [
                            'month' => $month,
                            'year' => $year,
                            'investor_code' => $investorCode,
                        ],
                        [
                            'user_id' => $user->id,
                            'investor_code' => $investorCode,
                            'capital' => $cumulativeCapital,
                            'investor_assets' => $cumulativeBalance,
                            'capital_gain_loss' => $monthlyCapitalGainLoss,
                            'monthly_net_gain_loss' => $monthlyNetGainLoss,
                            'monthly_net_percentage' => $monthlyNetPercentage,
                            'number_of_bonds' => $numberOfBonds,
                            'fees' => $monthlyFees,
                            'payment_distribution' => $paidCustodianDistribution,
                            'ending_balance' => $cumulativeBalance,
                            'ending_bond' =>  $numberOfBonds,
                        ]
                    );
                }
            }
        }
    }

    public function confirmOverwrite(Request $request)
    {
        // Check if the user confirmed the overwrite
        if ($request->input('overwrite') !== '1') {
            return redirect()->route('admin.investments.upload')->with('error', 'Upload cancelled.');
        }

        try {
            // Retrieve the file path from the session
            $filePath = $request->session()->get('pending_upload_file');
            $investorCodes = $request->session()->get('investor_codes', []);
            // Check if the file exists
            if (!$filePath || !Storage::exists($filePath)) {
                return redirect()->route('admin.investments.upload')->with('error', 'Uploaded file not found. Please upload again.');
            }
            // Load the file data again to get the records to delete
            $fileData = FacadesExcel::toArray(new \App\Imports\InvestorTransactionsImport, $filePath);
            $sheetData = $fileData[0];
            // Delete existing records
            foreach ($sheetData as $row) {
                $investorCode = $row['investor_code'] ?? null;
                $investorSubaccount = $row['investor_subaccount'] ?? $row['investor_sub_account'] ?? null;
                $monthlyDistribution = $row['monthly_distribution'] ?? null;
                $transactionType = $row['transaction_type'] ?? null;
                $month = $row['month'] ?? null;
                $year = $row['year'] ?? null;

                if ($investorCode && $investorSubaccount && $transactionType && $month && $year) {
                    Investment::where('investor_code', $investorCode)
                        ->where('investor_subaccount', $investorSubaccount)
                        ->where('monthly_distribution', $this->parseMonthlyDistribution($monthlyDistribution))
                        ->where('transaction_type', $transactionType)
                        ->where('month', $month)
                        ->where('year', $year)
                        ->delete();
                }
            }

            // Proceed with the import
            FacadesExcel::import(new \App\Imports\InvestorTransactionsImport, $filePath);

            // Calculate monthly statistics for the specific investor codes
            $this->calculateMonthlyStatistics($investorCodes);

            // Clean up the temporary file
            Storage::delete($filePath);
            $request->session()->forget('pending_upload_file');

            return redirect()->route('admin.investments')->with('success', 'File uploaded and existing records overwritten successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.investments')->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    private function parseDate($value, $use1904System = false)
    {
        if (is_null($value) || $value === '') {
            return now()->toDateString();
        }

        if (is_numeric($value)) {
            try {
                $baseDate = $use1904System
                    ? \Carbon\Carbon::create(1903, 12, 31) // 1904 system
                    : \Carbon\Carbon::create(1899, 12, 31); // 1900 system
                $days = $use1904System ? (int)$value + 1462 : (int)$value;
                return $baseDate->addDays($days)->toDateString();
            } catch (\Exception $e) {
                return now()->toDateString();
            }
        }

        try {
            return \Carbon\Carbon::createFromFormat('Y/m/d', $value)->toDateString();
        } catch (\Exception $e) {
            return now()->toDateString();
        }
    }

    private function parseMonthlyDistribution($value)
    {
        return $value === 'YES' ? 1 : 0;
    }

    public function show($id)
    {
        // Fetch statement data (replace with your actual data retrieval logic)
        $statement = InvestmentStatistic::with(['user'])->findOrFail($id);
        $transactions = Investment::select('date', 'transaction_type', DB::raw('SUM(amount) as amount'),'transaction')
                        ->where('investor_code', $statement->investor_code)
                        ->where('month', $statement->month)
                        ->where('year', $statement->year)
                        ->groupBy('date', 'transaction_type','transaction','amount')
                        ->get();
        $firstDay = "01" . " " . date('M',strtotime($statement->month)) ." ". $statement->year;
        $transact['opening'][] = array(
            'date' => $firstDay,
            'transaction' => 'Opening Balance',
            'amount' => 0.00,
            'balance' => 0.00,
            'opening' => true
        );
        $balance = 0;
        foreach ($transactions as $trans) {
            $xdata = $trans->toArray();
            $xdata['date'] = date('d M Y', strtotime($trans->date));
            $xdata['description'] = $trans->transaction;
            $balance += $trans->amount;
            $xdata['balance'] = $balance;
            $transact[$trans->date][] = $xdata;
        }
        $monthName = $statement->month;
        $year = $statement->year;
        $date = Carbon::createFromFormat('F Y', "$monthName $year");
        // Get the last day of the month
        $lastDay = $date->endOfMonth()->toDateString();
        $transact['closing'][] = array(
            'date' => date('d M Y',strtotime($lastDay)),
            'transaction' => 'Closing Balance',
            'amount' => "0",
            'balance' => $statement->ending_balance,
            'closing' => true
        );
        $statement_period = date('d M Y',strtotime($firstDay)). " - " .date('d M Y',strtotime($lastDay));
        $statementData = [
            'statement_number' => $statement->statement_number ?? 'CLP-25-012',
            'date' => $statement->date ?? '05 Mar 2025',
            'customer_id' => $statement->user->code ?? 'GURUSD',
            'customer_name' => $statement->user->name ?? 'Gurcan Gurel',
            'address' => $statement->user->address ?? 'Kucukbebek Dere Clkmazi 11/3, 34433 Bebek/Istanbul, Turkey',
            'bonds_subscribed' => $statement->number_of_bonds ?? 0,
            'total_amount_subscribed' => $statement->capital ?? 0.00,
            'bond_name' => $statement->bond_name ?? 'Sky Hybrid SA Ltd Bonds Series 001',
            'period_distribution' => $statement->month ." ". $statement->year ." / Monthly" ?? '',
            'statement_period' => $statement_period ?? '',
            'transactions' => $transact ?? [],
            'gross_capital_gain' => $statement->capital_gain_loss ?? 0.00,
            'net_amount' => $statement->ending_balance ?? 0.00,
        ];
        return view('admin.statements', compact('statementData'));
    }

    public function pdf($id)
    {
        $statement = InvestmentStatistic::with(['user'])->findOrFail($id);
        $transactions = Investment::select('date', 'transaction_type', DB::raw('SUM(amount) as amount'),'transaction')
                        ->where('investor_code', $statement->investor_code)
                        ->where('month', $statement->month)
                        ->where('year', $statement->year)
                        ->groupBy('date', 'transaction_type','transaction','amount')
                        ->get();
        $firstDay = "01" . " " . date('M',strtotime($statement->month)) ." ". $statement->year;
        $transact['opening'][] = array(
            'date' => $firstDay,
            'transaction' => 'Opening Balance',
            'amount' => 0.00,
            'balance' => 0.00,
            'opening' => true
        );
        $balance = 0;
        foreach ($transactions as $trans) {
            $xdata = $trans->toArray();
            $xdata['date'] = date('d M Y', strtotime($trans->date));
            $xdata['description'] = $trans->transaction;
            $balance += $trans->amount;
            $xdata['balance'] = $balance;
            $transact[$trans->date][] = $xdata;
        }
        $monthName = $statement->month;
        $year = $statement->year;
        $date = Carbon::createFromFormat('F Y', "$monthName $year");
        // Get the last day of the month
        $lastDay = $date->endOfMonth()->toDateString();
        $transact['closing'][] = array(
            'date' => date('d M Y',strtotime($lastDay)),
            'transaction' => 'Closing Balance',
            'amount' => "0",
            'balance' => $statement->ending_balance,
            'closing' => true
        );
        $statement_period = date('d M Y',strtotime($firstDay)). " - " .date('d M Y',strtotime($lastDay));
        $statementData = [
            'statement_number' => $statement->statement_number ?? 'CLP-25-012',
            'date' => $statement->date ?? '05 Mar 2025',
            'customer_id' => $statement->user->code ?? 'GURUSD',
            'customer_name' => $statement->user->name ?? 'Gurcan Gurel',
            'address' => $statement->user->address ?? 'Kucukbebek Dere Clkmazi 11/3, 34433 Bebek/Istanbul, Turkey',
            'bonds_subscribed' => $statement->number_of_bonds ?? 0,
            'total_amount_subscribed' => $statement->capital ?? 0.00,
            'bond_name' => $statement->bond_name ?? 'Sky Hybrid SA Ltd Bonds Series 001',
            'period_distribution' => $statement->month ." ". $statement->year ." / Monthly" ?? '',
            'statement_period' => $statement_period ?? '',
            'transactions' => $transact ?? [],
            'gross_capital_gain' => $statement->capital_gain_loss ?? 0.00,
            'net_amount' => $statement->ending_balance ?? 0.00,
        ];

        // Generate PDF using DOMPDF
        $path = public_path('images/cap-lion-point-black.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $pdf = Pdf::loadView('statements.pdf', compact('statementData','logo'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'helvetica',
            ]);

        // Return the PDF as a download or stream
        // return $pdf->stream('account-statement-' . $id . '.pdf');

        // For download instead of preview:
        return $pdf->download('account-statement-' . $id . '.pdf');
    }

    public function details($id)
    {
        // Fetch the InvestmentStatistics record with related Investment and User
        $statistic = InvestmentStatistic::findOrFail($id);
        $transactions = Investment::where('investor_code', $statistic->investor_code)
                        ->where('month', $statistic->month)
                        ->where('year', $statistic->year)
                        ->get();
        $transactions = array_map(function($row){
            $row['date'] = date('d M Y',strtotime($row['date']));
            $row['amount'] = number_format($row['amount'],2);
            return $row;
        },$transactions->toArray());
        return response()->json([
            'transactions' => $transactions,
        ]);
    }
}
