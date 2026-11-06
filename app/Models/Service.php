<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'price',
        'discounted_price',
        'discount_percent',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active'          => 'boolean',
        'price'              => 'decimal:2',
        'discounted_price'   => 'decimal:2',
        'discount_percent'   => 'integer',
    ];

    public function features()
    {
        return $this->hasMany(ServiceFeature::class)->orderBy('order');
    }

    public function heroes()
    {
        return $this->hasMany(Hero::class)->where('is_active', true);
    }

    // Добавь, если есть пакеты
    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }

    // Добавь, если есть отзывы
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}