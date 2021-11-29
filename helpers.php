<?php

use App\Models\Category;

if (!function_exists('categoryTree')) {
    // todo 优化层级level，拿几层
    function categoryTree($status = false) {
        $categories = Category::select([
            'id','pid','name','level','status'
        ])
            ->when($status !== false, function($query) use ($status) {
                $query->where('status', $status);
            })
            ->where('pid', 0)
            ->with([
                'children' => function ($query) use ($status){
                    $query->select(['id','pid','name','level','status'])
                        ->when($status !== false, function($query) use ($status) {
                            $query->where('status', $status);
                        });
                },
                'children.children' => function ($query) use ($status){
                    $query->select(['id','pid','name','level','status'])
                        ->when($status !== false, function($query) use ($status) {
                            $query->where('status', $status);
                        });
                },
                'children.children.children' => function ($query) use ($status){
                    $query->select(['id','pid','name','level','status'])
                        ->when($status !== false, function($query) use ($status) {
                        $query->where('status', $status);
                    });
                },
            ])
            ->get();
        return $categories;
    }
}

/**
 * 缓存没有被禁用的分类
 */
if(!function_exists('cache_categoryTree_enable')) {
    function cache_categoryTree_enable(){
        // 没有key的时候调用回调函数
        return cache()->rememberForever('cache_categoryTree_enable', function(){
            return categoryTree(1);
        });
    }
}

/**
 * 缓存所有的分类
 */
if(!function_exists('cache_categoryTree_all')) {
    function cache_categoryTree_all(){
        return cache()->rememberForever('cache_categoryTree_all', function(){
            return categoryTree();
        });
    }
}

/**
 * 刷新分类缓存
 */
if(!function_exists('forget_cache_category')){
    function forget_cache_category(){
        cache()->forget('cache_categoryTree_enable');
        cache()->forget('cache_categoryTree_all');
    }
}
