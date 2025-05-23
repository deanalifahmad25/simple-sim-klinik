<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product_m';

    public function orderProducts() {
        return $this->hasMany(OrderProduct::class, 'product_id', 'id');
    }
}
