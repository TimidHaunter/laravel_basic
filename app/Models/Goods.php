<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    // 可批量赋值的字段
    protected $fillable = ['user_id', 'category_id', 'title', 'description', 'price', 'stock', 'cover', 'pics', 'is_on', 'is_recommend', 'details'];

    /**
     * 强制属性转换
     */
    protected $casts = [
        'pics' => 'array',
    ];

    /**
     * 追加额外的属性
     */
    protected $appends = [
        'cover_url',
        'pics_url'
    ];

    /*
     * oss_url 修改器
     */
    public function getCoverUrlAttribute()
    {
        return oss_url($this->cover);
    }

    /**
     * pics_url 修改器
     * getXXXXAttribute
     */
    public function getPicsUrlAttribute()
    {
        // 遍历 $this->pics
        return collect($this->pics)->map(function ($item){
            return oss_url($item);
        });
    }


    /**
     * 创建商品和分类的关联
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * 创建商品和用户的关联
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 商品的所有评价
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'goods_id', 'id');
    }
}
