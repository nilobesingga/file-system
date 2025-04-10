<?php

namespace App\Imports;

use App\Models\Investment;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvestorTransactionsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $row = array_change_key_case($row, CASE_LOWER);
        $row = array_map('trim', $row);
        $user = User::where('code', $row['investor_code'])->first();
        return new Investment([
            'user_id' => $user->id,
            'investor_code' => $row['investor_code'],
            'investor_subaccount' => $row['investor_sub_account'],
            'investor_name' => $row['investor_name'],
            'monthly_distribution' => $this->parseMonthlyDistribution($row['monthly_distribution']),
            'bond_series' => $row['bond_serie'],
            'amount' => $this->parseAmount($row['amount']),
            'date' => $this->parseDate($row['date']),
            'transaction_type' => $row['transaction_type'],
            'transaction' => $row['transaction'],
            'month' => $row['month'],
            'year' => $row['year'],
            'explanation' => $row['explanation']
        ]);
    }

    private function parseMonthlyDistribution($value)
    {
        return $value === 'YES' ? 1 : 0;
    }

    private function parseAmount($value)
    {
        if (is_null($value) || $value === '') {
            return 0;
        }
        $value = str_replace(['(', ')', ','], '', $value);
        return floatval($value);
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
}
