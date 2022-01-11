<?php


namespace App\Transformers;


use App\Models\Cart;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    // 额外引入的属性
    protected $availableIncludes = ['goods'];

    public function transform(Cart $cart)
    {
        // 自定义响应格式
        return [
            'id'         => $cart->id,
            'user_id'    => $cart->user_id,
            'goods_id'   => $cart->goods_id,
            'num'        => $cart->num,
            'is_checked' => $cart->is_checked,
        ];
    }

    /**
     * 需要商品的信息，购物车表里面没有，需要商品表
     */
    public function includeGoods(Cart $cart)
    {
        return $this->item($cart->goods, new GoodsTransformer());
    }
}
