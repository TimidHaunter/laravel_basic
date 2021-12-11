<?php


namespace App\Transformers;

use App\Models\OrderDetails;
use League\Fractal\TransformerAbstract;

class OrderDetailsTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['goods'];

    public function transform(OrderDetails $orderDetails)
    {
        // 自定义响应格式
        return [
            'order_id'   => $orderDetails->order_id,
            'goods_id'   => $orderDetails->goods_id,
            'price'      => $orderDetails->price,
            'num'        => $orderDetails->num,
            'created_at' => $orderDetails->created_at,
            'updated_at' => $orderDetails->updated_at,
        ];

    }

    /**
     * 额外的商品信息
     */
    public function includeGoods(OrderDetails $orderDetails)
    {
        return $this->item($orderDetails->goods, new GoodsTransformer());
    }
}
