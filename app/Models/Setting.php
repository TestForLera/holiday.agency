<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'promo_code',
        'promo_text',
        'why_us_title',
        'why_us_text',
        'main_text',
    ];

    public static function current(): self
    {
        return static::query()->first() ?? static::query()->create([
            'hero_title' => 'Поздравление ростовой куклы в Челябинске',
            'hero_subtitle' => 'лучший подарок 2025',
            'promo_code' => 'BEST2025',
            'promo_text' => 'Скидка по промокоду',
            'why_us_title' => 'Почему выбирают нас',
            'why_us_text' => '',
            'main_text' => 'ПОЗДРАВЛЕНИЕ РОСТОВОЙ КУКЛОЙ',
        ]);
    }
}
