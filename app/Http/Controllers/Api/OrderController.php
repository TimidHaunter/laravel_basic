<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    /**
     * 订单预览页
     */
    public function preview()
    {
        // 地址
        $address = [
            ['id' => 1, 'name' => 'Tom1', 'address' => '北京1', 'phone' => '132XXX'],
            ['id' => 2, 'name' => 'Tom2', 'address' => '北京2', 'phone' => '132XXX'],
            ['id' => 3, 'name' => 'Tom3', 'address' => '北京3', 'phone' => '132XXX'],
        ];

        // 购物车数据
        $carts = Cart::where('user_id', auth('api')->id())
                     ->where('is_checked', 1)
                     // 管理商品数据
                     ->with('goods:id,cover,title')
                     ->get();

        // 返回数据
        return $this->response->array([
            'address' => $address,
            'carts'   => $carts,
        ]);
    }
}
