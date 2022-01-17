<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * 提交订单
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required', // TODO 地址要在地址表中存在 exists:address,id
        ],[
            'address_id.required' => '收货地址不能为空'
        ]);

        // 处理数据
        $user_id = auth('api')->id();
        $order_no = date('YmdHis') . rand(100000, 999999);
//        return $order_no;

        // 总金额
        $amount = 0;
        // 查出购物车数据
        $carts = Cart::where('user_id', $user_id)
            ->where('is_checked', 1)
            ->with('goods:id,price,stock,title')
            ->get();

        // 要插入的订单详情数据
        $insertData = [];

        foreach ($carts as $key => $cart) {
            // 如果有商品库存不足，提示用户重新选择
            if ($cart->goods->stock < $cart->num) {
                return $this->response->errorBadRequest($cart->goods->title . ' 库存不足，请重新选择商品');
            }

            $amount += $cart->goods->price * $cart->num;
            $insertData[] = [
                'goods_id' => $cart->goods_id,
                'price' => $cart->goods->price,
                'num' => $cart->num,
            ];
        }

//        return $amount;

        // 操作三个数据动作
        // 数据库事务
        try {
            DB::beginTransaction();

            // 生成订单
            $order = Order::create([
                'user_id' => $user_id,
                'order_no' => $order_no,
                'address_id' => $request->input('address_id'),
                'amount' => $amount,
            ]);

            // 生成订单详情，一条一条商品
            $order->orderDetails()->createMany($insertData);

            // 删除已经结算购物车商品
            Cart::where('user_id', $user_id)
                ->where('is_checked', 1)
                ->delete();

            // 减去商品的库存量
            foreach ($carts as $cart) {
                Goods::where('id', $cart->goods_id)->decrement('stock', $cart->num);
            }

            // 限购

            // 订单有效期 10min 失效，失效后，减去的库存加回来

            DB::commit();

            return $this->response->created();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

}
