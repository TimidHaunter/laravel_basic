<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    // 可批量赋值的字段
    protected $fillable = ['user_id', 'category_id', 'description', 'price', 'stock', 'cover', 'pics', 'is_on', 'is_recommend', 'details'];

    /**
     * 强制属性转换
     */
    protected $casts = [
        'pics' => 'array',
    ];
}
