<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Goods;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品详情
     * @param $good
     */
    public function show($id)
    {

        // 商品详情，增加修改器，返回商品 pics、cover 的 url 地址
        $goods = Goods::where('id', $id)
            // 关联商品相关评论
//            ->with('comments.user')
            // 只需要特定的字段
            ->with(['comments.user' => function ($query) {
                    $query->select('id', 'name', 'avatar');
                }])
            ->first()
            // 手动追加所需字段
            ->append('pics_url')
            ;

        // 推荐相似商品，查询同类商品
        $likeGoods = Goods::where('is_on', 1)
            ->select('id', 'title', 'price', 'cover', 'sales')
            ->where('category_id', $goods->category_id)
            // 随机取
            ->inRandomOrder()
            ->take(10)
            ->get()
            // 删除多余的字段，对单个对象使用
//                ->transform( function ($item) {
//                    return $item->setHidden(['pics_url']);
//                })

            // 删除多余的字段，对集合使用
//            ->makeHidden(['pics_url'])
            ;

        // 返回数据
        return $this->response->array([
            'goods' => $goods,
            'like_goods' => $likeGoods,
        ]);


    }
}
