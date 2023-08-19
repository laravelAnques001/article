<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model
{
    use HasFactory;
    protected $table = 'category_user';
    protected $fillable = ['category_id', 'user_id'];
}
