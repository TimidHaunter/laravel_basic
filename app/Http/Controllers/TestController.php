<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
//use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class TestController extends Controller
{
    public function index(Request $request)
    {
//        return User::all();
//        return User::find(1);

        // 一个自定义消息和状态码的普通错误。
//        return $this->response->error('自定义错误信息', 415);

//        return $this->response->errorNotFound();

//        return $this->response->errorInternal();

//        return $this->response->errorUnauthorized();

        // 自定义状态码
//        throw new \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException('User was updated prior to your request.');


        // 表单验证，失败，抛出异常
//        $request->validate([
//            'title' => 'bail|required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

//        $validateDate = $request->validate([
//            'title' => 'bail|required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        // 响应生成器使用transformers
//        $user = User::find(1);
//        return $user;
//        return $this->response->item($user, new UserTransformer());

        // 响应生成多条数据
//        $users = User::all();
//        return $this->response->collection($users, new UserTransformer());

        // 响应分页，并且自定义http header信息
        $pageSize = 2;
        $users = User::paginate($pageSize);
        return $this
            ->response
            ->paginator($users, new UserTransformer)
            ->withHeader('Customize-Header','Yintian')
            ->addMeta('Customize-Meta', 'Cxx')
            ->setStatusCode(201);

    }

    public function name()
    {
        $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('test.name');

        dd($url);
    }

    public function show()
    {
        echo 'users';
    }
}

