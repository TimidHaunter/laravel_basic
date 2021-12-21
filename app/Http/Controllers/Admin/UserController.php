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
     */
    public function index(Request $request)
    {
        // 搜索
        $name = $request->get('name');
        $email = $request->input('email');
//        dd($request);

        $pageSize = $request->input('page_size');
//        dd($pageSize);
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
     * 注入路由模型
     */
    public function show(User $user)
    {
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * 禁、启用用户
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 0 ? 1 : 0;
        $user->save();
        return $this->response->noContent();
    }
}
