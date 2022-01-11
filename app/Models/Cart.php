<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // 设置允许批量赋值的字段
    protected $fillable = ['user_id', 'goods_id', 'num'];
}
