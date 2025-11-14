<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description', 'stock', 'meli_item_id'];

    protected $table = 'products';

}
