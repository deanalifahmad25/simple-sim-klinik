<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registration;
use App\Models\Product;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'orderproduct_t';

    protected $fillable = [
        'registration_number',
        'qty'
    ];

    public function registration() {
        return $this->belongsTo(Registration::class, 'registration_number', 'registration_number');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($orderproduct) {
            $today = now()->toDateString();
            $countToday = static::whereDate('created_at', $today)->count() + 1;

            $prefix = 'ORD';
            $datePart = now()->format('dm');
            $yearPart = now()->format('Y');
            $sequence = str_pad($countToday, 4, '0', STR_PAD_LEFT);

            $orderproduct->order_number = $prefix . $datePart . $yearPart . $sequence;
        });
    }
}
