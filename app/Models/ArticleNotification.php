<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
    ];

    protected $hidden = ['updated_at'];

    protected $appends = [
        'day_ago',
    ];

    public function getDayAgoAttribute()
    {
        return $this->created_at ? $this->created_at->diffInDays(Carbon::now()) . ' days ago' : '';
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
