<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'link',
        'tags',
        'description',
        'image_type',
        'media',
        'thumbnail',
        'deleted_at',
        'status',
    ];

    protected $appends = [
        'media_url',
        'thumbnail_url',
        'like_count',
        'share_count',
        'impressions_count',
        'bookmark',
        'like',
        'day_ago',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
    ];

    public function getMediaUrlAttribute()
    {
        return $this->media ? asset(Storage::url($this->media)) : '';
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset(Storage::url($this->thumbnail)) : '';
    }

    public function getDayAgoAttribute()
    {
        return $this->created_at ? $this->created_at->diffInDays(Carbon::now()) . ' days ago' : '';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function articleLikeShare()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id');
    }

    public function getLikeCountAttribute()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id')->where('like', 1)->count() ?? 0;
    }

    public function getShareCountAttribute()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id')->where('share', 1)->count() ?? 0;
    }

    public function getImpressionsCountAttribute()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id')->sum('impressions') ?? 0;
    }

    public function getBookmarkAttribute()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id')->where('bookmark', 1)->where('user_id', auth()->id())->count() ?? 0;
    }

    public function getLikeAttribute()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id')->where('like', 1)->where('user_id', auth()->id())->count() ?? 0;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = isset(auth()->user()->id) ? auth()->user()->id : 0;
        });
    }
}
