<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
//use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class TestController extends Controller
{
    public function index()
    {
//        return User::all();
//        return User::find(1);

        // 一个自定义消息和状态码的普通错误。
//        return $this->response->error('自定义错误信息', 415);

//        return $this->response->errorNotFound();

//        return $this->response->errorInternal();

//        return $this->response->errorUnauthorized();

        // 自定义状态码
        throw new \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException('User was updated prior to your request.');
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

