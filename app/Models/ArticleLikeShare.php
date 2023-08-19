<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleLikeShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'like',
        'share',
        'bookmark',
    ];

    protected $hidden=[
        'created_at',
        'updated_at'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
