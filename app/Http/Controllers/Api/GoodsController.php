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
            ->with([
                'comments.user' => function ($query) {
                    $query->select('id', 'name', 'avatar');
                },
            ])
            ->first();

        // 商品相关评论，评论相关用户

        // 推荐相似商品

        // 返回数据
        return $this->response->array([
            'goods' => $goods,
            'like_goods' => '',
        ]);


    }
}
