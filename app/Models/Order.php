<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * 和用户的关联
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 和订单详情的关联
     */
    public function orderDetails()
    {
        // 一个订单有多个订单详情
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }
}
