<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 填充菜单数据
        $menus = [
            [
                'name' => '用户管理',
                'group' => 'menu',
                'level' => 1,
                'pid' => 0,
                'children' => [
                    [
                        'name' => '用户列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name' => '用户添加',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name' => '用户锁定',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name' => '用户注销',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ]
            ],
            [
                'name' => '商品管理',
                'group' => 'menu',
                'level' => 1,
                'pid' => 0,
                'children' => [
                    [
                        'name' => '商品列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name' => '商品添加',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name' => '商品锁定',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name' => '商品下架',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ]
            ],
            [
                'name' => '评价管理',
                'group' => 'menu',
                'level' => 1,
                'pid' => 0,
                'children' => [
                    [
                        'name' => '评价列表',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                    [
                        'name' => '评价回复',
                        'group' => 'menu',
                        'level' => 2,
                    ],
                ]
            ]
        ];



        // 循环分类数组，插入数据库
        foreach ($menus as $menu) {
            $children = $menu['children'];
            unset($menu['children']);

            $menuRes = Category::create($menu);
            $menuRes->children()->createMany($children);
        }

        // 清理缓存，可以使用监听器
        forgetCacheCategoryMenu();
    }



}
