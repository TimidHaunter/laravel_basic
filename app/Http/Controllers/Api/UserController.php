<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 显示用户个人信息
     */
    public function userInfo()
    {
//        $user = auth('api')->user();
//        dd($user);
        return $this->response->item(auth('api')->user(), new UserTransformer());
    }


    /**
     * 修改信息
     */
    public function updateUserInfo(Request $request)
    {
        $request->validate([
            'name' => 'required|max:16',
        ]);

        $user = auth('api')->user();
        $user->name = $request->input('name');
        $user->save();

        return $this->response->noContent();
    }

    /**
     * 更换用户头像
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required',
        ],[
            'avatar.required' => '用户头像 不能为空',
        ]);

        $user = auth('api')->user();
        $user->avatar = $request->input('avatar');
        $user->save();

        return $this->response->noContent();
    }
}
