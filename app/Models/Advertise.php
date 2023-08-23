<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Advertise extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'target',
        'latitude',
        'longitude',
        'redis',
        'budget',
        'start_date',
        'end_date',
        'status',
        'budget_type',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function article(){
        return $this->belongsTo(Article::class,'article_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function advertiseLatLong(){
        return $this->hasMany(AdvertiseLatLong::class,'advertise_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = isset(auth()->user()->id) ? auth()->user()->id : 0;
            $model->updated_by = isset(auth()->user()->id) ? auth()->user()->id : 0;
        });
        static::updating(function ($model) {
            $model->updated_by = isset(auth()->user()->id) ? auth()->user()->id : 0;
        });
    }
}
