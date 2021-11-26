<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * true  开启表单验证
     * false 关闭
     *
     * 开关放在表单验证的父类，总开关
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
