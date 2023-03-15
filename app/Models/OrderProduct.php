<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderProduct extends Model
{
    use HasFactory;

    // protected $fillable = ['order_id', 'product_name', 'price', 'quantity'];
    protected $guard = [];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
