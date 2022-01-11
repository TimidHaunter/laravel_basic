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
     * 增加数量
     * PUT
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 移除购物车
     * DELETE
     */
    public function destroy($id)
    {
        //
    }
}
