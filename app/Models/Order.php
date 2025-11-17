<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','status','total','mp_preference_id','metadata'];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
