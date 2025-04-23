<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Files extends Model
{
    protected $table = "files";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Many-to-many relationship with users who have read the file
    public function readers()
    {
        return $this->belongsToMany(User::class, 'file_user', 'file_id', 'user_id')
        ->withPivot('read_at')
        ->withTimestamps();
    }

    // Check if the current user has read the file
    public function isReadByCurrentUser()
    {
        return $this->readers()->where('user_id', Auth::user()->id)->exists();
    }

    public function statement()
    {
        return $this->hasMany(InvestmentStatistic::class, 'id', 'statement_id');
    }

}
