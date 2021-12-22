<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoodsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 查询分类group=goods，level=3的id
        $categoryId = Category::where('level', 3)->where('group', 'goods')->pluck('id');

        return [
            // 批量添加商品数据
            'user_id' => 1,
            'category_id' => $this->faker->randomElement($categoryId),
            'title' => $this->faker->text(20),
            'description' => $this->faker->text(60),
            'price' => $this->faker->numberBetween(1, 100000),
            'stock' => $this->faker->numberBetween(100, 999),
            'cover' => 'https://placeimg.com/640/480/any',
            'is_on' => $this->faker->randomElement([0, 1]),
            'is_recommend' => $this->faker->randomElement([0, 1]),
            'pics' => [
                'https://placeimg.com/640/480/any',
                'https://placeimg.com/640/480/any',
                'https://placeimg.com/640/480/any',
            ],
            'details' => $this->faker->paragraphs(4, true),
        ];
    }
}
