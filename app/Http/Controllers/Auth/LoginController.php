<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends BaseController
{
    /*
     * 用户登录
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)){
            return $this->response->errorUnauthorized();
        }

        return $this->respondWithToken($token);
    }

    /**
     * 用户退出
     */
    public function logout()
    {
//        return 'logout';

        auth('api')->logout();

//        return response()->json(['message' => 'Successfully logged out']);

        // 返回无状态响应
        return $this->response->noContent();
    }

    /**
     * 用户刷新，刷新的是 token
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * 格式化返回
     */
    public function respondWithToken($token)
    {
//        return response()->json([
//            'access_token' => $token,
//            'token_type' => 'Bearer',
//            'expires_in' => auth('api')->factory()->getTTL() * 60
//        ]);

        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
