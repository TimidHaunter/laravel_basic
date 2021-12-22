<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => '生鲜肉禽',
                'group' => 'goods',
                'level' => 1,
                'pid' => 0,
                'children' => [
                    [
                        'name' => '海鲜',
                        'group' => 'goods',
                        'level' =>2,
                        'children' => [
                            ['name' => '鲈鱼', 'group' => 'goods', 'level' => 3],
                            ['name' => '花蛤', 'group' => 'goods', 'level' => 3],
                            ['name' => '小龙虾', 'group' => 'goods', 'level' => 3],
                        ],
                    ],
                    [
                        'name' => '牛羊',
                        'group' => 'goods',
                        'level' =>2,
                        'children' => [
                            ['name' => '牛腩', 'group' => 'goods', 'level' => 3],
                            ['name' => '羊腿', 'group' => 'goods', 'level' => 3],
                            ['name' => '牛肚', 'group' => 'goods', 'level' => 3],
                        ],
                    ],
                    [
                        'name' => '猪',
                        'group' => 'goods',
                        'level' =>2,
                        'children' => [
                            ['name' => '猪蹄', 'group' => 'goods', 'level' => 3],
                            ['name' => '猪大肠', 'group' => 'goods', 'level' => 3],
                            ['name' => '猪五花', 'group' => 'goods', 'level' => 3],
                        ],
                    ],
                ]
            ],
            [
                'name' => '图书文娱',
                'group' => 'goods',
                'level' => 1,
                'pid' => 0,
                'children' => [
                    [
                        'name' => '图书',
                        'group' => 'goods',
                        'level' =>2,
                        'children' => [
                            ['name' => '文学', 'group' => 'goods', 'level' => 3],
                            ['name' => '教育', 'group' => 'goods', 'level' => 3],
                            ['name' => '人文社科', 'group' => 'goods', 'level' => 3],
                        ],
                    ],
                    [
                        'name' => '文娱',
                        'group' => 'goods',
                        'level' =>2,
                        'children' => [
                            ['name' => '音乐', 'group' => 'goods', 'level' => 3],
                            ['name' => '影视', 'group' => 'goods', 'level' => 3],
                            ['name' => '游戏', 'group' => 'goods', 'level' => 3],
                        ],
                    ],
                ],
            ]
        ];
        // 循环分类数组，插入数据库
        foreach ($categories as $category1) {
            $children1 = $category1['children'];
            unset($category1['children']);
            // 插入第一层
            $menuRes1 = Category::create($category1);

            // 循环第二层
            foreach ($children1 as $category2) {
                $children2 = $category2['children'];

                unset($category2['children']);

                // 插入第二层
                $menuRes2 = $menuRes1->children()->create($category2);
                $menuRes2->children()->createMany($children2);
            }
        }

        forgetCacheCategoryMenu();
    }
}
