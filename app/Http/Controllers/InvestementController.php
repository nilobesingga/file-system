<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Imports\InvestorTransactionsImport;
use App\Models\Category;
use App\Models\Files;
use App\Models\FileUser;
use App\Models\Investment;
use App\Models\InvestmentStatistic;
use App\Models\StatementSeries;
use App\Models\User;
use App\Notifications\NewStatementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use Nette\DI\Definitions\Statement;

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
        $investments = InvestmentStatistic::with('user','statement')->latest()->paginate(15);
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
            $filterParams = $request->only([
                'investor_code',
                'investor_name',
                'selected_investor',
                'year',
                'month'
            ]);
            return redirect()->route('admin.investment-list',$filterParams)->with('success', (($statistic->is_publish == false) ? 'Unpublish ': 'Publish') .' status updated successfully.');
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
            // Loop through the data and check for existing records
            $counter = 1;
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
                $isPublish = InvestmentStatistic::where('investor_code', $investorCode)
                            ->where('month', $month)
                            ->where('year', $year)
                            ->where('is_publish', 1)
                            ->exists();
                if ($isPublish) {
                    return redirect()->route('admin.investments')->with('error', 'The file cannot be uploaded because the statement is already published. Line no '.$counter . " Investor Code: " . $investorCode . " Month: " . $month . " Year: " . $year);
                }

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

    public function reconciliation(){
        $investorCodes = [
            'ATLUSD',
            'ENIUSD',
            'ERMUSD',
            'GURUSD',
            'JAMUSD',
            'KEMUSD'
        ];
        $this->calculateMonthlyStatistics($investorCodes);
    }

    public function calculateMonthlyStatistics(array $investorCodes)
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
                ->whereNotIN('transaction_type', [
                    Investment::TRANSACTION_TYPE_COMPOUND_DISTRIBUTION,
                    Investment::TRANSACTION_TYPE_MONTHLY_DISTRIBUTION
                ])
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
                    $investor_assets = ($cumulativeBalance > 0) ? $cumulativeBalance : 0;
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
                            'investor_assets' => $investor_assets,
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
                $unixTimestamp = ($value - 25569) * 86400;
                return gmdate("Y-m-d", $unixTimestamp);
                // $baseDate = $use1904System
                //     ? \Carbon\Carbon::create(1903, 12, 31) // 1904 system
                //     : \Carbon\Carbon::create(1899, 12, 31); // 1900 system
                // $days = $use1904System ? (int)$value + 1462 : (int)$value;
                // return $baseDate->addDays($days)->toDateString();
            } catch (\Exception $e) {
                return now()->toDateString();
            }
        }

        try {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $value)->toDateString();
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
        $ref = StatementSeries::where('statement_id', $id)->first();
        $transactions = Investment::select('date', 'transaction_type', DB::raw('SUM(amount) as amount'),'transaction')
                        ->where('investor_code', $statement->investor_code)
                        ->where('month', $statement->month)
                        ->where('year', $statement->year)
                        ->whereNotIN('transaction_type', [
                            Investment::TRANSACTION_TYPE_COMPOUND_DISTRIBUTION,
                            Investment::TRANSACTION_TYPE_MONTHLY_DISTRIBUTION
                        ])
                        ->groupBy('date', 'transaction_type','transaction','amount')
                        ->get();
        $firstDay =  date('d M Y',strtotime("01" . " " .$statement->month ." ". $statement->year));
        $transact['opening'][] = array(
            'date' => $firstDay,
            'transaction' => 'Opening Balance',
            'amount' => 0,
            'balance' => $statement->investor_assets ?? 0.00,
            'opening' => true
        );
        $balance = $statement->investor_assets ?? 0;
        foreach ($transactions as $trans) {
            $xdata = $trans->toArray();
            $xdata['date'] = date('d M Y', strtotime($trans->date));
            $xdata['description'] = $trans->transaction;
            $balance += $trans->amount;
            $xdata['balance'] = $balance;
            $transact[$trans->date][] = $xdata;
        }
        //get the last key of the array $transact
        $lastKey = array_key_last($transact);
        // $monthName = $statement->month;
        // $year = $statement->year;
        // $date = Carbon::createFromFormat('F Y', $lastKey);
        // Get the last day of the month
        // $lastDay = $date->endOfMonth()->toDateString();
        $transact['closing'][] = array(
            'date' => date('d M Y',strtotime($lastKey)),
            'transaction' => 'Closing Balance',
            'amount' => "0",
            'balance' => $statement->ending_balance,
            'closing' => true
        );
        $statement_period = date('d M Y',strtotime($firstDay)). " - " .date('d M Y',strtotime($lastKey));
        $statementData = [
            'statement_number' => $ref->statement_no ?? '',
            'date' => date('d M Y'),
            'customer_id' => $statement->user->code ?? '',
            'customer_name' => $statement->user->name ?? '',
            'address' => $statement->user->address ?? '',
            'bonds_subscribed' => $statement->number_of_bonds ?? 0,
            'total_amount_subscribed' => $statement->capital ?? 0.00,
            'bond_name' => $ref->bond_name ?? '',
            'period_distribution' => $statement->month ." ". $statement->year ?? '',
            'monthly_distribution' => ($statement->payment_distribution != 0) ? 'Yes' :  'No',
            'statement_period' => $statement_period ?? '',
            'transactions' => $transact ?? [],
            'gross_capital_gain' => $statement->capital_gain_loss ?? 0.00,
            'net_amount' => $statement->ending_balance ?? 0.00,
        ];
        return view('admin.statements', compact('statementData'));
    }

    public function pdf($id, $return = false)
    {
        $statement = InvestmentStatistic::with(['user'])->findOrFail($id);
        $ref = StatementSeries::where('statement_id', $id)->first();
        $transactions = Investment::select('date', 'transaction_type', DB::raw('SUM(amount) as amount'),'transaction')
                        ->where('investor_code', $statement->investor_code)
                        ->where('month', $statement->month)
                        ->where('year', $statement->year)
                        ->whereNotIN('transaction_type', [
                            Investment::TRANSACTION_TYPE_COMPOUND_DISTRIBUTION,
                            Investment::TRANSACTION_TYPE_MONTHLY_DISTRIBUTION
                        ])
                        ->groupBy('date', 'transaction_type','transaction','amount')
                        ->get();
        $firstDay = date('d M Y',strtotime("01" . " ".$statement->month ." ". $statement->year));
        $transact['opening'][] = array(
            'date' => $firstDay,
            'transaction' => 'Opening Balance',
            'amount' => 0,
            'balance' => $statement->investor_assets ?? 0.00,
            'opening' => true
        );
        $balance = $statement->investor_assets ?? 0;
        foreach ($transactions as $trans) {
            $xdata = $trans->toArray();
            $xdata['date'] = date('d M Y', strtotime($trans->date));
            $xdata['description'] = $trans->transaction;
            $balance += $trans->amount;
            $xdata['balance'] = $balance;
            $transact[$trans->date][] = $xdata;
        }
        //get the last key of the array $transact
        $lastKey = array_key_last($transact);
        //get the last value of the array $transact
        // $lastValue = $transact[$lastKey];
        // dd($lastValue);
        // $monthName = $statement->month;
        // $year = $statement->year;
        // $date = Carbon::createFromFormat('F Y', $lastKey);
        // Get the last day of the month
        // $lastDay = $date->endOfMonth()->toDateString();
        $transact['closing'][] = array(
            'date' => date('d M Y',strtotime($lastKey)),
            'transaction' => 'Closing Balance',
            'amount' => "0",
            'balance' => $statement->ending_balance,
            'closing' => true
        );
        $statement_period = date('d M Y',strtotime($firstDay)). " - " .date('d M Y',strtotime($lastKey));
        $statementData = [
            'statement_number' => $ref->statement_no ?? '',
            'date' => date('d M Y'),
            'customer_id' => $statement->user->code ?? '',
            'customer_name' => $statement->user->name ?? '',
            'address' => $statement->user->address ?? '',
            'bonds_subscribed' => $statement->number_of_bonds ?? 0,
            'total_amount_subscribed' => $statement->capital ?? 0.00,
            'bond_name' => $ref->bond_name ?? '',
            'period_distribution' => $statement->month ." ". $statement->year ?? '',
            'monthly_distribution' => ($statement->payment_distribution != 0) ? 'Yes' :  'No',
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
        if($return){
            $filename = 'account-statement-' . $id . '-' . time() . '.pdf';
            $folderPath = 'account-statement';
            $fullPath = $folderPath . '/' . $filename;
            Storage::disk('public')->put($fullPath, $pdf->output());
            return [
                'path' => $fullPath,
                'name' => $filename
            ];
        }
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

    public function generateStatement(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $statement = DB::table('investment_statistics')->where('id', $id)->first();
            if (!$statement) {
                return response()->json(['error' => 'Investment statistic not found.'], 404);
            }
            $user = User::where('code', $statement->investor_code)->first();
            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }
            $reference = FileHelper::generateStatementRef();
            $bond_name = "Sky Hybrid SA Ltd Bonds Series 001";

            StatementSeries::where('statement_id', $id)->delete();

            DB::table('statement_series')->insert([
                'statement_id' => $id,
                'statement_no' => $reference,
                'investor_code' => $statement->investor_code,
                'bond_name' => $bond_name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $categoryId = 1;
            $userId = $user->id;

            $monthName = $statement->month;
            $year = $statement->year;

            $statement_period = date('Y-m-d',strtotime("01" . " " . $monthName ." ". $year));
            // $date = Carbon::createFromFormat('F Y', "$monthName $year");
            // $lastDay = $date->endOfMonth()->toDateString();
            // $statement_period = date('d M Y',strtotime($firstDay)). " - " .date('d M Y',strtotime($lastDay));
            // $statement_period = date('Y-m-d',strtotime($lastDay));

            $files = $this->pdf($id, true);
            $path = $files['path'] ?? '';
            if (!$path) {
                return response()->json(['error' => 'Error generating PDF.'], 500);
            }
            $filename = $files['name'] ?? '';
            if (!$filename) {
                return response()->json(['error' => 'Error generating PDF.'], 500);
            }

            $files = Files::where('statement_id', $id)->first();
            if ($files) {
                Files::where('statement_id', $id)->where('id',$files->id)->delete();
                FileUser::where('file_id', $files->id)->delete();
            }
            Files::create([
                'name' => $filename,
                'path' => $path,
                'user_id' => $userId,
                'category_id' => $categoryId,
                'document_name' => $bond_name ?? '',
                'statement_no' => $reference,
                'statement_id' => $id,
                'statement_period' => $statement_period,
                'number_of_bonds' => $statement->number_of_bonds,
                'amount_subscribed' => $statement->capital,
                'currency' => 'USD',
                'created_by' => Auth::user()->id
            ]);
            DB::commit();
            $filterParams = $request->only([
                'investor_code',
                'investor_name',
                'selected_investor',
                'year',
                'month',
                'is_publish'
            ]);
            return redirect()->route('admin.investment-list',$filterParams)->with('success', 'Statement generated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.investment-list')->with('error', 'Error on generating statement: ' . $e->getMessage());
        }
    }

    public function sendNotification(Request $request, $userId)
    {
        $user = User::where('id', $userId)->first();
        if (!$user) {
            return redirect()->route('admin.investment-list')->with('error', 'User not found.');
        }
        $portalUrl = url('/dashboard');
        $user->notify(new NewStatementNotification($portalUrl));
        $filterParams = $request->only([
            'investor_code',
            'investor_name',
            'selected_investor',
            'year',
            'month',
            'is_publish'
        ]);
        return redirect()->route('admin.investment-list',$filterParams)->with('success', 'Email notification sent to investor email successfully');
    }

    //make a function to delete the investment
    public function distroy(Request $request)
    {
        // return redirect()->back()->with('success', 'Investment deleted successfully.');

        DB::beginTransaction();
        $filterParams = $request->only([
            'investor_code',
            'investor_name',
            'selected_investor',
            'year',
            'month',
            'is_publish'
        ]);

        try {
            $id = $request->input('id');
            if (!$id) {
                response()->json(['success' => false , 'message' => 'Investment ID is required.']);
            }
            $investment = InvestmentStatistic::findOrFail($id);
            if ($investment->is_publish == 1) {

                return response()->json(['success' => false , 'message' => 'Investment record is published and cannot be deleted.']);
            }
            $months = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
            $targetMonth = $investment->month;
            $targetIndex = array_search($targetMonth, $months);

            $monthsToCheck = array_slice($months, $targetIndex + 1); // Months after the target month
            $investmentExists = InvestmentStatistic::where('investor_code', $investment->investor_code)
                ->where('year', $investment->year)
                ->whereIn('month', $monthsToCheck)
                ->exists();
            if ($investmentExists) {
                return response()->json(['success' => false , 'message' => 'Investment record cannot be deleted because there are records after the ' . $investment->month .'.'], 400);
            }

            StatementSeries::where('statement_id', $id)->delete();
            $files = Files::where('statement_id', $id)->first();
            if ($files) {
                Files::where('statement_id', $id)->where('id',$files->id)->delete();
                FileUser::where('file_id', $files->id)->delete();
            }

            Investment::where('investor_code', $investment->investor_code)
                ->where('month', $investment->month)
                ->where('year', $investment->year)
                ->delete();

            $investment->delete();

            DB::commit();
            return response()->json(['success' => true , 'message' => 'Investment deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting investment: ' . $e->getMessage()], 500);
        }
    }
}
