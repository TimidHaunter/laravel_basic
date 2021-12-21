<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建用户
        $user = User::create(['name' => '超级管理员', 'email' => 'root@163.com', 'password' => bcrypt('123456')]);

//        $user = DB::table('users')->insert([
//            'name' => '超级管理员',
//            'email' => 'root@163.com',
//            'password' => bcrypt('123456'),
//        ]);

        // 给用户分配角色
        $user->assignRole('root');
//        $user->assignRole('admin');

        /**
         * 分类管理员
         */
        $user = User::create(['name' => '分类管理员', 'email' => 'admin_category@163.com', 'password' => bcrypt('123456')]);
        $user->assignRole('admin_category');

        $insert = [
            ['name' => '全站管理员', 'email' => 'admin@163.com', 'password' => bcrypt('123456')],
            ['name' => '用户管理员', 'email' => 'admin_user@163.com', 'password' => bcrypt('123456')],
            ['name' => '订单管理员', 'email' => 'admin_order@163.com', 'password' => bcrypt('123456')],
            ['name' => '评论管理员', 'email' => 'admin_comment@163.com', 'password' => bcrypt('123456')],
            ['name' => '图片管理员', 'email' => 'admin_img@163.com', 'password' => bcrypt('123456')],
            ['name' => '商品管理员', 'email' => 'admin_goods@163.com', 'password' => bcrypt('123456')],
        ];

        foreach ($insert as $k=>$i) {
            $insert[$k]['created_at'] = date('Y-m-d H:i:s');
            $insert[$k]['updated_at'] = date('Y-m-d H:i:s');
        }

        DB::table('users')->insert($insert);

//        User::create([
//            ['name' => '全站管理员', 'email' => 'admin@163.com', 'password' => bcrypt('123456')],
//            ['name' => '用户管理员', 'email' => 'admin_user@163.com', 'password' => bcrypt('123456')],
//            ['name' => '订单管理员', 'email' => 'admin_order@163.com', 'password' => bcrypt('123456')],
//            ['name' => '评论管理员', 'email' => 'admin_comment@163.com', 'password' => bcrypt('123456')],
//            ['name' => '图片管理员', 'email' => 'admin_img@163.com', 'password' => bcrypt('123456')],
//            ['name' => '商品管理员', 'email' => 'admin_goods@163.com', 'password' => bcrypt('123456')],
//        ]);
    }
}
