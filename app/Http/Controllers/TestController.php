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

    /**
     * 登录
     *
     * 使用 `email` 和 `password` 登录。
     *
     * @Post("/login")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"email": "yintian_129@126.com", "password": "123456"}),
     *      @Response(200, body={"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2FjbC5sYXJhdmVsX2Jhc2ljLmNvbVwvYXBpXC9sb2dpbiIsImlhdCI6MTYzNzg1MjU3MiwiZXhwIjoxNjM3ODU2MTcyLCJuYmYiOjE2Mzc4NTI1NzIsImp0aSI6Ing4UjlGdnBxMnFjNWxTcHoiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Ea6nJvhkL7TkR6MRfUdv65n_fyj-lw4KiILHSKsWhBU","token_type":"Bearer","expires_in":3600}),
     *      @Response(401, body={"error": {"username": {"Username is already taken."}}})
     * })
     */
    public function login()
    {
//        $email = $request->input('email');
//        $password = $request->input('password');

//        dd(bcrypt('357159'));

        $credentials = request(['email', 'password']);
//        dd($credentials);
        if (!$token = auth('api')->attempt($credentials)) {
//            return response()->json(['error' => 'Unauthorized'], 401);

            return $this->response->errorUnauthorized();
        }

        return $this->respondWithToken($token);
    }

    /**
     * 需要添加 jwt 认证
     */
    public function users()
    {
        // 所有用户
//        $users = User::all();
//        return $this->response->collection($users, new UserTransformer());

        // 从 Token 获取用户信息
        $user = app('Dingo\Api\Auth\Auth')->user();
        return $user;
    }

    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    // 内部调用
    public function inner()
    {
        // 内部分发器
        $dispatcher = app('Dingo\Api\Dispatcher');
        // 请求内部接口 api/test
//        $users = $dispatcher->get('api/test');

        // 有些内部接口需要认证，登录后才能访问
//        $users = $dispatcher->get('api/users');

        // 模拟用户 be( 用户实例 )
        $user = User::find(1);
        $users = $dispatcher->be($user)->get('api/users');
        return $users;
    }

    /**
     * api 版本
     * 需要在 HTTP header 头增加 Accept:application/vnd.YOUR_SUBTYPE.v1+json
     * vnd=.env API_STANDARDS_TREE
     * YOUR_SUBTYPE=.env API_SUBTYPE
     */

    public function inner2()
    {
        $user = User::find(2);
        return $user;
    }
}

