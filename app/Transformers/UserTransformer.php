<?php


namespace App\Transformers;


use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        // 自定义响应格式
        return [
            'id'          => $user->id,
            'name'        => $user->name,
            'email'       => $user->email,
            'created_at'  => $user->created_at ? $user->created_at : '时间遥远'
        ];
    }
}
