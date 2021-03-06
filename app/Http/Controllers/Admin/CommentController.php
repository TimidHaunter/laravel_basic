<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Comment;
use App\Models\Goods;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * GET
     * 评价列表
     */
    public function index(Request $request)
    {
        // 获取搜索条件
        $rate = $request->query('rate');

        $goods_title = $request->query('goods_title');

        $comments = Comment::when($rate, function ($query) use ($rate) {
            $query->where('rate', $rate);
        })
        ->when($goods_title, function ($query) use ($goods_title) {
            // 先查询相关商品的ID，连表查询
            $goods_ids = Goods::where('title', 'like', "%{$goods_title}%")->pluck('id');
            $query->whereIn('goods_id', $goods_ids);
        })
        ->paginate(1);
        // dingo api响应生成器要配合 transformers 使用
        return $this->response->paginator($comments, new CommentTransformer());
    }

    /**
     * GET
     * 评价详情
     */
    public function show(Comment $comment)
    {
        return $this->response->item($comment, new CommentTransformer());
    }

    /**
     * PATCH
     * 评价回复
     */
    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'reply' => 'required|max:255'
        ], [
            'reply.required' => '回复不能为空',
            'reply.max'      => '回复不能超过255字符'
        ]);

        // 更新回复
        $comment->reply = $request->input('reply');
        $comment->save();
        return $this->response->noContent();
    }

}
