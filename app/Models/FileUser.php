<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUser extends Model
{
    protected $table = "file_user";
    protected $primaryKey = "id";
    protected $guarded = ["id"];

}
