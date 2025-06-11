<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Support\Facades\RateLimiter;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'is_admin',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'show_welcome_modal' => 'boolean',
        'force_password_change' => 'boolean'
    ];

    // Relationship with categories (many-to-many)
    public function categories()
    {
        return $this->belongsToMany(CategoryUser::class, 'category_user','user_id','category_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_user');
    }


    // Relationship with files
    public function files()
    {
        return $this->hasMany(Files::class);
    }

    public function isAdmin()
    {
        return $this->is_admin; // ✅ Accessor for checking admin status
    }

    public function readFiles()
    {
        return $this->belongsToMany(Files::class, 'file_user', 'user_id', 'file_id')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, $this));
    }
}
