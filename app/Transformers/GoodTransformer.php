<?php


namespace App\Transformers;


use App\Models\Category;
use App\Models\Good;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class GoodTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category', 'user'];

    public function transform(Good $good)
    {
        // 自定义响应格式
        return [
            'category_id' => $good->category_id,
//            'category_name' => Category::find($good->category_id)->name,
            'title' => $good->title,
            'description' => $good->description,
            'price' => $good->price,
            'stock' => $good->stock,
            'cover' => $good->cover,
            'pics' => $good->pics,
            'is_on' => $good->is_on,
            'is_recommend' => $good->is_recommend,
            'details' => $good->details,
            'created_at' => $good->created_at,
            'updated_at' => $good->updated_at,
        ];
    }

    /**
     * 额外的分类数据
     */
    public function includeCategory(Good $good)
    {
        return $this->item($good->category, new CategoryTransformer());
    }

    /**
     * 额外的用户数据
     */
    public function includeUser(User $user)
    {
        return $this->item($user->user, new UserTransformer());
    }
}
