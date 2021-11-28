<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 用户列表
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        // 搜索，todo 获取不到参数
        $name = $request->input('name');
        $email = $request->input('email');

        $pageSize = 2;
        // 闭包用到外部变量 $name，需要使用 use 传参进来
        $users = User::when($name, function($query) use ($name) {
                $query->where('name', 'like', '%$name%');
            })
            ->when($email, function($query) use ($email) {
                $query->where('email', $email);
            })
            ->paginate($pageSize);
//        return $users;
        return $this->response->paginator($users, new UserTransformer());
    }

    /**
     * 用户详情
     */
    public function show($id)
    {
        //
    }

    /**
     * 禁、启用用户
     */
    public function lock()
    {

    }
}
