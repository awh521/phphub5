<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'body',
        'user_id',
        'topic_id',
        'body_original',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($topic) {
            SiteStatus::newReply();
        });
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function scopeWhose($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id)->with('topic');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
