<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class SlideRequest extends BaseRequest
{
    /**
     * 验证每个字段规则
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'img'   => 'required',
        ];
    }

    /**
     * 返回每个字段提示
     */
    public function messages()
    {
        return [
            'title.required' => '轮播图标题不能为空',
            'img.required'   => '轮播图图片不能为空',
        ];
    }
}
