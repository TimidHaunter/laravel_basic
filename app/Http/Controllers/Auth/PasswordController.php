<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class PasswordController extends BaseController
{
    /**
     * 修改密码
     * PUT
     */
    public function updatePassword(Request $request)
    {
//        return 'password/update';

        // 新密码和旧密码不能一样

        $request->validate([
            'old_password' => 'required|min:6|max:16',
            'password' => 'required|min:6|max:16|confirmed|different:old_password',
        ],[
            'old_password.required'=>'旧密码 不能为空',
            'old_password.min'=>'旧密码 不能少于六个字符',
            'old_password.max'=>'旧密码 不能多于十六个字符',
            'password.different'=>'新密码 不能和旧密码一样',
        ]);

        // 严重旧密码是否正确
        $oldPassword = $request->input('old_password');
        $user = auth('api')->user();

        if (!password_verify($oldPassword, $user->password)) {
            return $this->response->errorBadRequest('旧密码不正确');
        }

        // 更新用户密码
        $password = $request->input('password');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return $this->response->noContent();
    }
}
