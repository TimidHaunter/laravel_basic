<?php

namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    // 可 include 的方法
    protected $availableIncludes = ['user', 'goods'];

    public function transform(Comment $comment)
    {
        $pics_url = [];
        if (is_array($comment->pics)) {
            foreach ($comment->pics as $p) {
                array_push($pics_url, oss_url($p));
            }
        }

        // 自定义响应格式
        return [
            'id'         => $comment->id,
            // 关联用户名称和商品名称
            'user_id'    => $comment->user_id,
            'goods_id'   => $comment->goods_id,

            'content'    => $comment->content,
            'rate'       => $comment->rate,
            'reply'      => $comment->reply,
            'pics'       => $comment->pics,
            'pics_url'   => $pics_url,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at
        ];
    }

    /**
     * 想获取评价里 user_id 关联的 User 表里的 name
     */
    public function includeUser(Comment $comment)
    {
        return $this->item($comment->user, new UserTransformer());
    }

    /**
     * 想获取评价里 good_id 关联的 Goods 表里的 name
     */
    public function includeGoods(Comment $comment)
    {
        return $this->item($comment->goods, new GoodsTransformer());
    }
}
