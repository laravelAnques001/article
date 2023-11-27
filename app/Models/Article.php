<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'impression',
        'share',
        'deleted_at',
        'status',
        'type',
        'post_images'
    ];

    protected $appends = [
        // 'media_url',
        // 'thumbnail_url',
        'like_count',
        // 'share_count',
        // 'impressions_count',
        'bookmark',
        'like',
        'day_ago',
        'web_link',
        'ad_impression_count',
        'ad_impression_charge_count',
        'ad_click_count',
        'ad_click_charge_count',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
    ];

    // public function getMediaUrlAttribute()
    // {
    //     return $this->media ? asset(Storage::url($this->media)) : '';
    // }

    // public function getThumbnailUrlAttribute()
    // {
    //     return $this->thumbnail ? asset(Storage::url($this->thumbnail)) : '';
    // }

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
        return $this->belongsToMany(Category::class, 'articles_categories');
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

    // public function getImpressionsCountAttribute()
    // {
    //     return $this->hasMany(ArticleLikeShare::class, 'article_id')->sum('impressions') ?? 0;
    // }

    public function getBookmarkAttribute()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id')->where('bookmark', 1)->where('user_id', auth()->id())->count() ?? 0;
    }

    public function getLikeAttribute()
    {
        return $this->hasMany(ArticleLikeShare::class, 'article_id')->where('like', 1)->where('user_id', auth()->id())->count() ?? 0;
    }

    public function getAdImpressionCountAttribute()
    {
        return $this->transaction()->where('impression', 1)->count() ?? 0;
    }

    public function getAdImpressionChargeCountAttribute()
    {
        return $this->transaction()->where('impression', 1)->sum('impression_charge') ?? 0;
    }

    public function getAdClickCountAttribute()
    {
        return $this->transaction()->where('click', 1)->count() ?? 0;
    }

    public function getAdClickChargeCountAttribute()
    {
        return $this->transaction()->where('click', 1)->sum('click_charge') ?? 0;
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'article_id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = isset(auth()->user()->id) ? auth()->user()->id : 0;
        });
    }

    public function getWebLinkAttribute()
    {
        return url('article-view/' . base64_encode($this->id));
    }
}
