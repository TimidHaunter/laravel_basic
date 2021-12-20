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
if(!function_exists('cacheCategoryTreeEnable')) {
    function cacheCategoryTreeEnable(){
        // 没有key的时候调用回调函数
        return cache()->rememberForever('cacheCategoryTreeEnable', function(){
            return categoryTree('goods', 1);
        });
    }
}

/**
 * 缓存所有的分类
 */
if(!function_exists('cacheCategoryTreeAll')) {
    function cacheCategoryTreeAll(){
        return cache()->rememberForever('cacheCategoryTreeAll', function(){
            return categoryTree();
        });
    }
}

/**
 * 刷新分类缓存
 */
if(!function_exists('forgetCacheCategory')){
    function forgetCacheCategory(){
        cache()->forget('cacheCategoryTreeEnable');
        cache()->forget('cacheCategoryTreeAll');
    }
}

/**
 * 缓存没有被禁用的菜单
 */
if(!function_exists('cacheCategoryTreeMenuEnable')) {
    function cacheCategoryTreeMenuEnable(){
        // 没有key的时候调用回调函数
        return cache()->rememberForever('cacheCategoryTreeMenuEnable', function(){
            return categoryTree('menu', 1);
        });
    }
}

/**
 * 缓存所有的菜单
 */
if(!function_exists('cacheCategoryTreeMenuAll')) {
    function cacheCategoryTreeMenuAll(){
        return cache()->rememberForever('cacheCategoryTreeMenuAll', function(){
            return categoryTree('menu');
        });
    }
}

/**
 * 刷新菜单缓存
 */
if(!function_exists('forgetCacheCategoryMenu')){
    function forgetCacheCategoryMenu(){
        cache()->forget('cacheCategoryTreeMenuEnable');
        cache()->forget('cacheCategoryTreeMenuAll');
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
