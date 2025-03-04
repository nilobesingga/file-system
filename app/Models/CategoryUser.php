<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model
{
    protected $table = "category_user";
    protected $primaryKey = "id";
    protected $guarded = ["id"];
}
