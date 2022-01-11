<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    /**
     * 购物车商品列表
     * GET
     */
    public function index()
    {
        //
    }

    /**
     * 加入购物车
     * POST
     */
    public function store(Request $request)
    {
        // 验证数据
        // exists:goods,id 在商品表里必须存在，且必须是ID
        $request->validate([
            'goods_id' => 'required|exists:goods,id'
        ],[
            'goods_id.required' => '商品 ID不能为空',
            'goods_id. exists' => '商品不存在',
        ]);

        Cart::create([
            'user_id' => auth('api')->id(),
            'goods_id' => $request->input('goods_id'),
            'num' => $request->input('num', 1),
        ]);
    }

    /**
     * 增加商品数量
     * PUT
     */
    public function update(Request $request, Cart $cart)
    {
        // 自定义验证规则，就不要用|，使用数组[]
        $request->validate([
            'num' => [
                'required',
                'gte:1',
                // 自定义验证规则
                // num 不能超过商品的库存，先通过商品ID，找到库存，可以通过模型关联
                function($attribute, $value, $fail) use ($cart) {
                    if  ($value > $cart->goods->stock) {
                        $fail('数量 不能超过最大库存');
                    }
                }
            ]
        ],[
            'num.required' => '数量 不能为空',
            'num.gte' => '数量 最少是1',
        ]);

        // 更新数据
        $cart->num = $request->input('num');
        $cart->save();

        return $this->response->noContent();
    }

    /**
     * 移除购物车商品
     * DELETE
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return $this->response->noContent();
    }
}
