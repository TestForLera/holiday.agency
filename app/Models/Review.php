<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'order_id',
        'service_id',
        'package_id',
        'rating',
        'comment',
        'author_name',
        'avatar_url',
        'content',
        'category',
        'photo_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getTextAttribute(): string
    {
        return $this->comment ?? $this->content ?? '';
    }
}
