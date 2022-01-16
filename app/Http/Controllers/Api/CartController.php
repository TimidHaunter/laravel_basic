<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Cart;
use App\Models\Goods;
use App\Transformers\CartTransformer;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    /**
     * 购物车商品列表
     * GET
     */
    public function index()
    {
        $carts = Cart::where('user_id', auth('api')->id())->get();
        return $this->response->collection($carts, new CartTransformer());
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
            'goods_id' => 'required|exists:goods,id',
            // 加入购物车数量不能超过库存数量
            'num' => [
                function ($attribute, $value, $fail) use ($request) {
                    $goods = Goods::find($request->goods_id);
                    if ($value > $goods->stock) {
                        $fail('加入购物车的数量 不能超过库存');
                    }
                }
            ]
        ],[
            'goods_id.required' => '商品 ID不能为空',
            'goods_id. exists' => '商品不存在',
        ]);

        // 查询购物车数据是否存在
        $cart = Cart::where('user_id', auth('api')->id())
            ->where('goods_id', $request->input('goods_id'))
            ->first();

        if (!empty($cart)) {
            $cart->num = $request->input('num', 1);
            $cart->save();
            return $this->response->noContent();
        }

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
