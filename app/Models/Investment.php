<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $table = 'investment';
    protected $guarded = ['id'];
    const TRANSACTION_TYPE_CAPITAL_DEPOSIT_WITHDRAW = 101;
    const TRANSACTION_TYPE_CAPITAL_GAIN_LOSS = 102;
    const TRANSACTION_TYPE_SUCCESS_FEE = 201;
    const TRANSACTION_TYPE_PAID_CUSTODIAN_DISTRIBUTION = 301;
    const TRANSACTION_TYPE_COMPOUND_DISTRIBUTION = 901; // High Watermark Level of Compounded Distribution
    const TRANSACTION_TYPE_MONTHLY_DISTRIBUTION = 902; // High Watermark Level of Monthly Distribution

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statistics()
    {
        return $this->hasMany(InvestmentStatistic::class);
    }
}
