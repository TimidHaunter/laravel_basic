<?php

namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{

    public function transform(Comment $comment)
    {
        // 自定义响应格式
        return [
            'id' => $comment->id,
            // 关联用户名称和商品名称
            'user_id' => $comment->user_id,
            'goods_id' => $comment->goods_id,
            'content' => $comment->content,
            'rate' => $comment->rate,
            'reply' => $comment->reply,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at
        ];
    }
}
