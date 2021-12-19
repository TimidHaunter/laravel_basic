<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'all');

        if ($type == 'all') {
            return cache_categoryTree_menu_all();
        } else {
            return cache_categoryTree_menu_enable();
        }
    }
}
