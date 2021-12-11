<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $order)
    {
        // 自定义响应格式
        return [
            'user_id'      => $order->user_id,
            'order_no'     => $order->order_no,
            'amount'       => $order->amount,
            'status'       => $order->status,
            'address_id'   => $order->address_id,
            'express_type' => $order->express_type,
            'express_no'   => $order->express_no,
            'pay_time'     => $order->pay_time,
            'pay_type'     => $order->pay_type,
            'trade_no'     => $order->trade_no,
        ];
    }
}
