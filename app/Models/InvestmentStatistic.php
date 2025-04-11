<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentStatistic extends Model
{
    protected $table = 'investment_statistics';
    protected $guarded = ['id'];

    protected $casts = [
        'is_publish' => 'boolean'
    ];
    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
