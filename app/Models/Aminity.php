<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aminity extends Model
{
    use HasFactory;
    protected $table = 'aminities';
    protected $fillable = ['name','deleted_at'];

    public function business()
    {
        return $this->belongsToMany(Business::class, 'aminities_businesses');
    }
}
