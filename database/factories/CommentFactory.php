<?php

namespace Database\Factories;

use App\Models\Goods;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 获取用户 ID
        $userIds = User::pluck('id');
        // 获取商品 ID
        $goodsIds = Goods::pluck('id');


        return [
            'user_id' => $this->faker->randomElement($userIds),
            'goods_id' => $this->faker->randomElement($goodsIds),
            'rate' => $this->faker->numberBetween(1, 3),
            'content' => $this->faker->text(40),
            'reply' => $this->faker->text(60),
            'pics' => [
                'https://placeimg.com/640/480/any',
                'https://placeimg.com/640/480/any',
                'https://placeimg.com/640/480/any',
            ],
        ];
    }
}
