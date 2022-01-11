<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // 设置允许批量赋值的字段
    protected $fillable = ['user_id', 'goods_id', 'num'];

    /**
     * 建立购物车和商品之间的模型关联
     * todo: 类似连表查询?
     *
     * @related：关联的类名
     * @foreignKey：本表外键
     * @ownerKey：本表键id
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

}
