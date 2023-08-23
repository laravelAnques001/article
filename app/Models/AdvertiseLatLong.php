<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdvertiseLatLong extends Model
{
    use HasFactory;

    protected $fillable=[
        'advertise_id',
        'latitude',
        'longitude',
    ];
    public $timestamps  =false;

    public function advertiseLatLong(){
        return $this->belongTo(Advertise::class,'advertise_id');
    }
    
}
