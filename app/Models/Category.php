<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'description'
    ];

    // Relationship with users (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'category_user','user_id', 'category_id');
    }

    // Relationship with files
    public function files()
    {
        return $this->hasMany(Files::class);
    }
}
