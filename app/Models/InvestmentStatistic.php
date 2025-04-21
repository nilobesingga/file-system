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
        return $this->hasMany(Investment::class, 'investor_code','investor_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statement()
    {
        return $this->hasOne(StatementSeries::class, 'statement_id', 'id');
    }
}
