<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\BaseController;
use App\Jobs\SendMailDatabase;
use App\Models\SendMail;
use Illuminate\Http\Request;

class SendMailDatabaseController extends BaseController
{
    public function store(Request $request) {
        $request->validate([
            'email' => 'required',
            'content' => 'required'
        ],[
            'email.required' => '用户邮箱 不能为空',
            'content.required' => '邮箱内容 不能为空',
        ]);

        //插入数据库
        $model = new SendMail();
        $model->email = $request->input('email');
        $model->content = $request->input('content');
        $model->status = $model->tries = 0;
        $dbRes = $model->save();

        $job = new SendMailDatabase($model);
        //延时
        $job->delay(200);
        //分发，入列
        $disRes = $this->dispatch($job);
//        var_dump($dbRes, $disRes);
        return $this->response->noContent();
    }
}
