<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    /**
     * GET
     * 订单列表
     */
    public function index(Request $request)
    {
        // 查询条件
        // 单号
        $order_no = $request->input('order_no');
        $trade_no = $request->input('trade_no');
        $status   = $request->input('status');

        $orders = Order::when($order_no, function ($query) use ($order_no) {
            $query->where('order_no', $order_no);
        })
        ->when($trade_no, function ($query) use ($trade_no) {
            $query->where('trade_no', $trade_no);
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate();

//        $orders = Order::paginate();
        return $this->response->paginator($orders, new OrderTransformer());
    }

    /**
     * GET
     * 订单详情
     */
    public function show(Order $order)
    {
//        return $this->response->item($order, new OrderTransformer());
    }

    /**
     * PATCH
     * 发货
     */
    public function post()
    {

    }
}
