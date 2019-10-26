<?php

namespace App;
use DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Article extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'articles';

    protected $fillable = [
        'title',
        'schoolgsm_id',
        'content',
        'author',
        'status',
        'type',
        'categories',
        'tags',
        'guid',
        'page',
        'sticky',
        'format',
        'share_link',
        'image',
        'video',
        'comment_status',
        'featured_media',
        'user_id',
        'liked_ids',
        'favorite_ids',
        'kupon',
        ];

    protected $dates = [
        'deleted_at',
    ];

    // public function comments()
    // {
    //     return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    // }
    public function comments()
    {
        return $this->hasMany('App\Comment','commentable_id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function favorite()
    {
        return $this->belongsToMany(Users::class, null, 'article_ids', 'favorite_ids');
    }

    public function liked()
    {
        return $this->belongsToMany(Users::class, null, 'liked_ids', 'liked_ids');
    }
    public function schoolgsm(){
        return $this->belongsTo('App\SchoolGsm','schoolgsm_id');
    }
}
