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

        //初始化数据库
        $model = new SendMail();
        $model->email = $request->input('email');
        $model->content = $request->input('content');
        $model->status = $model->tries = 0;
        $model->save();
        $job = new SendMailDatabase($model);
        $job->delay(10);
        $this->dispatch($job);

        return $this->response->noContent();
    }
}
