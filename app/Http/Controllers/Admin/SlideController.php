<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SlideRequest;
use App\Models\Slide;
use App\Transformers\SlideTransformer;
use Illuminate\Http\Request;

class SlideController extends BaseController
{
    /**
     * GET
     */
    public function index()
    {
        $slides = Slide::paginate(10);
        return $this->response->paginator($slides, new SlideTransformer());
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
    public function show(Slide $slide)
    {
        return $this->response->item($slide, new SlideTransformer());
    }

    /**
     * PATCH
     * 更新
     */
    public function update(SlideRequest $slideRequest, Slide $slide)
    {
        // 批量赋值
        $slide->update($slideRequest->all());
        return $this->response->noContent();
    }

    /**
     * DELETE
     * 删除
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();
        return $this->response->noContent();
    }

    /**
     * 更新 seq 字段
     */
    public function seq(Request $request, Slide $slide)
    {
        $slide->seq = $request->input('seq', 1);
        $slide->save();
        return $this->response->noContent();
    }
}
