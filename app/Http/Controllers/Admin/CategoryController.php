<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * 分类列表
     * 树状结构
     */
    public function index(Request $request)
    {
//        $pid = $request->input('pid');
//        dd($request);

        return cache_categoryTree_all();
    }

    /**
     * 添加分类，最大三级分类
     */
    public function store(Request $request)
    {
        // 验证参数
        $request->validate([
            'name' => 'required|max:16'
        ], [
            'name.required' => '分类名称不能为空'
        ]);

        // 获取pid
        $pid = $request->input('pid', 0);

        // 获取level
        $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);

        // 不能超过四级分类
        if ($level > 4) {
            return $this->response->errorBadRequest('不能超过三级分类');
        }

        $insertData = [
            'name' => $request->input('name'),
            'pid' => $pid,
            'level' => $level
        ];

        Category::create($insertData);

        // 刷新缓存
        forget_cache_category();

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
