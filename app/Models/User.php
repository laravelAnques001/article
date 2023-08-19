<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'password',
        'image',
        'otp',
        'expire_at',
        'device_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = true;
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset(Storage::url($this->image)) : asset('assets/images/McrkmG7D6RoKVN7k42ojo4mMeN6WM7uZ5RmhUoeM.jpg');
    }

    public function article()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function articleLikeShare()
    {
        return $this->hasMany(ArticleLikeShare::class, 'user_id');
    }

    public function wallet()
    {
        return $this->hasMany(Wallet::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
}
