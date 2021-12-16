<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Mail\OrderPost;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        // 正常发货逻辑
//        $order->express_type = $request->input('express_type');
//        $order->express_no   = $request->input('express_no');
//        $order->status = Config::get('constants.Shipped');; // 发货状态，建议设置成常量
//        $order->save();
//
//        // 使用邮箱发送
//        // 发送邮件耗时，比如发短信，发邮件可以放入队列当中
//        // send 换 queue，使用默认队列
//        // 配置队列
//        Mail::to($order->user)->queue(new OrderPost($order));

        // 关闭队列
//        Mail::to($order->user)->send(new OrderPost($order));


        /**
         * 监听事件
         */
        // 事件辅助函数分发邮件
//        event(new \App\Events\OrderPost(
//            $order,
//            $request->input('express_type'),
//            $request->input('express_no')
//        ));

        // 使用事件分发，触发监听
        \App\Events\OrderPost::dispatch(
            $order,
            $request->input('express_type'),
            $request->input('express_no')
        );


        return $this->response->noContent();
    }
}
