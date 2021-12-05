<?php

namespace App\Transformers;

use App\Models\Goods;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class GoodTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category', 'user', 'comments'];

    public function transform(Goods $goods)
    {
        $pics_url = [];
        foreach ($goods->pics as $p) {
            array_push($pics_url, oss_url($p));
        }

        // 自定义响应格式
        return [
            'category_id' => $goods->category_id,
//            'category_name' => Category::find($good->category_id)->name,
            'title' => $goods->title,
            'description' => $goods->description,
            'price' => $goods->price,
            'stock' => $goods->stock,
            'cover' => $goods->cover,
            'cover_url' => oss_url($goods->cover), // 域名拼接
            'pics' => $goods->pics,
            'pics_url' => $pics_url,
            'is_on' => $goods->is_on,
            'is_recommend' => $goods->is_recommend,
            'details' => $goods->details,
            'created_at' => $goods->created_at,
            'updated_at' => $goods->updated_at,
        ];
    }

    /**
     * 额外的分类数据
     */
    public function includeCategory(Goods $goods)
    {
        return $this->item($goods->category, new CategoryTransformer());
    }

    /**
     * 额外的用户数据
     */
    public function includeUser(User $user)
    {
        return $this->item($user->user, new UserTransformer());
    }

    /**
     * 商品额外的评价数据
     */
    public function includeComments(Goods $goods)
    {
        return $this->collection($goods->comments, new CommentTransformer());
    }
}
