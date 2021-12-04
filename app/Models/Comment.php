<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * 评论 模型
 * @package App\Models
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * 强制属性转换
     */
    protected $casts = [
        'pics' => 'array',
    ];

    /**
     * 创建评价和用户的关联
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 评价所属的商品
     */
    public function goods()
    {
        return $this->belongsTo(Good::class, 'goods_id', 'id');
    }
}
