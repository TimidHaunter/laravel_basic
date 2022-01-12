<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'goods_id', 'price', 'num'];

    /**
     * 所关联的商品
     */
    public function goods()
    {
        return $this->hasOne(Goods::class, 'id', 'goods_id');
    }
}
