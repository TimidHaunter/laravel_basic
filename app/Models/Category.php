<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // 可批量赋值的字段
    protected $fillable = ['name', 'pid', 'level'];

    /**
     * 分类的子类
     */
    public function children()
    {
        // 模型关联
        // 之前都是数组关联
        return $this->hasMany(Category::class, 'pid', 'id');
    }
}
