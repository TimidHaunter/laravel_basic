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
        // todo 获取不到 get 的 type 参数
        $type = $request->input('type', 'all');
//        dd($request);

        if ($type == 'all') {
            return cacheCategoryTreeAll();
        } else {
            return cacheCategoryTreeEnable();
        }
    }

    /**
     * 添加分类，最大三级分类
     */
    public function store(Request $request)
    {
        $insertData = $this->checkInput($request);

        if (!is_array($insertData)) return $insertData;

        Category::create($insertData);

        return $this->response->created();
    }

    /**
     * 分类详情
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * 分类更新
     */
    public function update(Request $request, Category $category)
    {
        $updateData = $this->checkInput($request);

        if (!is_array($updateData)) return $updateData;

        $category->update($updateData);

        return $this->response->noContent();
    }

    /**
     * 分类禁、启用
     */
    public function status(Category $category)
    {
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();

        return $this->response->noContent();
    }

    /**
     * 校验需要添加的数据
     * @param $request
     * @return array|void
     */
    protected function checkInput($request)
    {
        // 验证参数
        $request->validate([
            'name' => 'required|max:16'
        ], [
            'name.required' => '分类名称不能为空'
        ]);

        // 获取分组
        $group = $request->input('group', 'goods');

        // 获取pid
        $pid = $request->input('pid', 0);

        // 获取level
        $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);

        // 不能超过四级分类
        if ($level > 4) {
            return $this->response->errorBadRequest('不能超过三级分类');
        }

        return [
            'name' => $request->input('name'),
            'group' => $group,
            'pid' => $pid,
            'level' => $level
        ];
    }
}
