<?php


namespace App\Transformers;


use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        // 自定义响应格式
        return [
            'id'   => $category->category_id,
            'name' => $category->name
        ];
    }
}
