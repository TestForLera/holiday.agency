<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'original_price',
        'discounted_price',
        'discount_percent',
        'services_json',
        'is_active',
        'order',
    ];

    protected $casts = [
        'services_json'     => 'array',
        'is_active'         => 'boolean',
        'original_price'    => 'decimal:2',
        'discounted_price'  => 'decimal:2',
        'discount_percent'  => 'integer',
    ];

    /**
     * Получить модели услуг из services_json
     * (удобный хелпер)
     */
    public function getServicesAttribute()
    {
        if (empty($this->services_json)) {
            return collect();
        }

        // Предполагаем, что в services_json лежат id услуг
        return Service::whereIn('id', $this->services_json)
            ->orderBy('order')
            ->get();
    }

    /**
     * Либо, если в services_json лежат уже готовые данные (title, price и т.д.),
     * тогда просто возвращаем массив:
     */
    // public function getServicesAttribute()
    // {
    //     return collect($this->services_json ?? []);
    // }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
