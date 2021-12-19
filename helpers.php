<?php

use App\Models\Category;

if (!function_exists('categoryTree')) {
    // todo 优化层级level，拿几层
    function categoryTree($group = 'goods', $status = false) {
        $categories = Category::select([
            'id','pid','name','level','status'
        ])
            ->when($status !== false, function($query) use ($status) {
                $query->where('status', $status);
            })
            ->where('group', $group)
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
            return categoryTree('goods', 1);
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
 * 缓存没有被禁用的菜单
 */
if(!function_exists('cache_categoryTree_menu_enable')) {
    function cache_categoryTree_menu_enable(){
        // 没有key的时候调用回调函数
        return cache()->rememberForever('cache_categoryTree_menu_enable', function(){
            return categoryTree('menu', 1);
        });
    }
}

/**
 * 缓存所有的菜单
 */
if(!function_exists('cache_categoryTree_menu_all')) {
    function cache_categoryTree_menu_all(){
        return cache()->rememberForever('cache_categoryTree_menu_all', function(){
            return categoryTree('menu');
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

/**
 * 获取阿里云OSS域名
 * todo 是否要加斜杠，是否HTTPS，是否一系列的考虑，这里简单写一个
 */
if(!function_exists('oss_url'))
{
    function oss_url($key)
    {
        return config('filesystems')['disks']['oss']['bucket_url'] . '/' . $key;
    }
}
