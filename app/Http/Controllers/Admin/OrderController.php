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
        return $this->response->item($order, new OrderTransformer());
    }

    /**
     * PATCH
     * 发货，就是更新状态数据
     */
    public function post(Request $request, Order $order)
    {
        // 验证提交参数，就两个字段，不需要单独的 Requests 文件
        // 直接使用表单过滤验证
        $request->validate([
            'express_type' => 'required|in:SF,YT,YD',
            'express_no'   => 'required',
        ], [
            'express_type.required' => '快递类型必填',
            'express_type.in'       => '快递类型必须是SF,YT,YD',
            'express_no.required'   => '快递单号必填',
        ]);

        $order->express_type = $request->input('express_type');
        $order->express_no   = $request->input('express_no');
        $order->status = 3; // 发货状态，建议设置成常量
        $order->save();
        return $this->response->noContent();
    }
}
