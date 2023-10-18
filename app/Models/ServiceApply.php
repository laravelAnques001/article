<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceApply extends Model
{
    use HasFactory;

    protected $table = 'service_applies';

    protected $fillable = [
        'service_id',
        'user_id',
        'name',
        'mobile_number',
        'email',
        'message',
        'deleted_at',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
