<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        echo 'Test.index';
    }

    public function name()
    {
        $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('test.name');
        dd($url);
    }
}
