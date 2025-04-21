<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatementSeries extends Model
{
    protected $table = 'statement_series';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
