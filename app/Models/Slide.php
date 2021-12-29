<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'img', 'status', 'seq'];

    /**
     * 追加额外的 img_url 属性
     */
    protected $appends = ['img_url'];

    // 修改器
    public function getImgUrlAttribute()
    {
        return oss_url($this->img);
    }
}
