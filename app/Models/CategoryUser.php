<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model
{
    protected $table = "category_user";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    public function users()
    {
        return $this->belongsToMany(User::class, 'category_user', 'category_id', 'user_id');
    }
}
