<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Goods;
use App\Transformers\GoodsTransformer;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     */
    public function index(Request $request)
    {
        // 商品搜索条件
        $title = $request->input('title');
        $categoryId = $request->input('category_id');

        // 商品分页数据
        $goods = Goods::select('id', 'title', 'price', 'cover', 'pics', 'category_id')
            ->where('is_on', 1)
            // 当 title 存在，调用匿名函数
            ->when($title, function ($query) use ($title){
                $query->where('title', 'like', "%{$title}%");
            })
            // 分类 id 搜索
            ->when($categoryId, function ($query) use ($categoryId){
                $query->where('category_id', $categoryId);
            })

            ->withCount('comments')
            ->simplePaginate(20)

            // 给分页链接追加属性
            ->appends([
                'title' => $title,
                'category_id' => $categoryId
            ]);

        // 推荐商品
        $recommendGoods = Goods::select('id', 'title', 'price', 'cover')
            ->where('is_on', 1)
            ->where('is_recommend', 1)
            ->withCount('comments')
            ->inRandomOrder()
            ->take(10)
            ->get();

        // 分类数据
        $categories = cacheCategoryTreeEnable();

        return $this->response->array([
//            'goods' => json_decode($this->response->paginator($goods, new GoodsTransformer())->morph()->getContent()),
            'goods' => $goods,
            'recommend_goods' => $recommendGoods,
            'categories' => $categories
        ]);
    }

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
