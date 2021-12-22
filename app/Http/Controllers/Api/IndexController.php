<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Goods;
use App\Models\Slide;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * 返回首页数据
     */
    public function index()
    {
//        return ['api/index'];
        // 轮播图
        $slides = Slide::where('status', 1)
            ->orderBy('seq')
            ->get();

        // 分类数据
        $category = cacheCategoryTreeAll();

        // 推荐商品
        $goods = Goods::where('is_on', 1)
            ->where('is_recommend', 1)
            ->get();
        return $this->response->array([
            'slides' => $slides,
            'category' => $category,
            'goods' => $goods
        ]);

    }

}
