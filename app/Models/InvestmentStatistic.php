<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentStatistic extends Model
{
    protected $table = 'investment_statistics';
    protected $guarded = ['id'];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }
}
