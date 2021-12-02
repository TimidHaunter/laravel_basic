<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;

class OssController extends BaseController
{
    /**
     * 生成Oss上传Token
     */
    public function token()
    {
//        return 'OssToken';

        // 引入配置文件
        $disk = Storage::disk('oss');
//        dd($disk);

        /**
         * 1. 前缀如：'images/'
         * 2. 回调服务器 url
         * 3. 回调自定义参数，oss 回传应用服务器时会带上
         * 4. 当前直传配置链接有效期
         */
        $config = $disk->signatureConfig($prefix = '/', $callBackUrl = '', $customData = [], $expire = 3000);
//        dd($config);

        $configArr = json_decode($config, true);
        return $this->response->array($configArr);
    }
}
