<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 可以批量赋值的字段
    protected $fillable = ['user_id', 'order_no', 'address_id', 'amount'];

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

    /**
     * 远程一对多，订单关联的远程商品
     * order->orderDetails->goods
     */
    public function goods()
    {
        return $this->hasManyThrough(
            Goods::class, // 远程模型
            OrderDetails::class, // 中间模型
            'order_id', // 本模型和中间表关联的键
            'id', // 远程模型的外键
            'id', // 中间模型和远程模型的键
            'goods_id' // 中间模型和远程模型关联的健
        );
    }

}
