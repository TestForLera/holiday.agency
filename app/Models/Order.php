<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'service_id',
        'date',
        'time',
        'address',
        'apartment',
        'comment',
        'status',
        'price',
        'hero_type', // 'rostovaya' or 'animaciya'
        'hero_name',
        'duration',
        'children_count',
        'children_ages',
        'additional_services', // json
        'fio',
        'email',
        'phone',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'additional_services' => 'array',
        'children_count' => 'integer',
    ];

    public const STATUSES = [
        'oformlenie' => 'Оформление',
        'zvonok' => 'Звонок',
        'zhdet_predoplatu' => 'Ждет предоплату',
        'zhdem_vstrechi' => 'Ждем встречи с вами',
        'zhdet_otzyva' => 'Ждет вашего отзыва',
        'completed' => 'Завершен',
        'cancelled' => 'Отменён',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
