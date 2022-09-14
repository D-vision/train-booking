<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    const Cities = ['AAA','BBB','CCC','DDD'];

    protected $fillable = [
        'order_id',
        'from',
        'to',
        'train',
        'car',
        'car_type',
        'place',
        'departure_at',
        'arrival_at',
    ];

    protected $casts = [
        'departure_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCarTypeStringAttribute()
    {
        return $this->car_type==1?'Плацкарт':'Купе';
    }
}
