<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:16',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:16|confirmed'
        ];
    }

    /**
     * 自定义提示
     */
    public function messages()
    {
        // 字段名.规则 => 提示语
        return [
            'name.required' => '昵称不能为空。',
            'email.required' => '邮箱不能为空。',
            'email.email' => '请输入正确的邮箱地址。',
            'email.unique' => '邮箱已经被注册。'
        ];
    }
}
