<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SlideRequest;
use App\Models\Slide;

class SlideController extends BaseController
{
    /**
     * GET
     */
    public function index()
    {
        //
    }

    /**
     * POST
     * 添加
     */
    public function store(SlideRequest $slideRequest)
    {
        // 查询最大的seq，Slide::max('seq')不存在的时候为1
        $maxSeq = Slide::max('seq') ?? 0;
        $maxSeq++;

//        dd($maxSeq);
        $slideRequest->offsetSet('seq', $maxSeq);
        // 批量赋值
        Slide::create($slideRequest->all());
        return $this->response->created();
    }

    /**
     * GET
     * 详情
     */
    public function show($id)
    {
        //
    }

    /**
     * PATCH
     * 更新
     */
    public function update(SlideRequest $slideRequest, $id)
    {
        //
    }

    /**
     * DELETE
     * 删除
     */
    public function destroy($id)
    {
        //
    }
}
