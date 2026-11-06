<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'service_id',
        'hero_id',
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

    public function hero()
    {
        return $this->belongsTo(Hero::class);
    }
}
