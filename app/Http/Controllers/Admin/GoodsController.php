<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\Good;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     */
    public function index()
    {
        //
    }

    /**
     * POST
     * 商品添加
     */
    public function store(GoodsRequest $request)
    {
        $user_id = auth('api')->id();
//        dd($user_id);
//        $insertData = $request->all();
//        $insertData['user_id'] = $user_id;
//        Good::create($insertData);

        $request->offsetSet('user_id', $user_id);
        // 表单验证
        Good::create($request->all());
        return $this->response->created();
    }

    /**
     * 商品详情
     */
    public function show($id)
    {
        //
    }

    /**
     * 商品编辑
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 商品上架
     */
    public function isOn()
    {

    }

    /**
     * 商品推荐
     */
    public function isRecommend()
    {

    }
}
