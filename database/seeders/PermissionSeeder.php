<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 权限迁移文件，录入添加权限
     *
     * @return void
     */
    public function run()
    {
        // 添加权限
        $permissions = [
//            ['name'=>'', 'zh_name'=>'', 'guard_name'=>'api'],


            ['name'=>'users.index', 'zh_name'=>'用户列表',    'guard_name'=>'api'],
            ['name'=>'users.show',  'zh_name'=>'用户详情',    'guard_name'=>'api'],
            ['name'=>'users.lock',  'zh_name'=>'用户禁、启用', 'guard_name'=>'api'],

            ['name'=>'category.index',  'zh_name'=>'分类列表', 'guard_name'=>'api'],
            ['name'=>'category.store',  'zh_name'=>'分类添加', 'guard_name'=>'api'],
            ['name'=>'category.show',  'zh_name'=>'分类详情', 'guard_name'=>'api'],
            ['name'=>'category.update',  'zh_name'=>'分类更新', 'guard_name'=>'api'],
            ['name'=>'category.status',  'zh_name'=>'分类禁、启用', 'guard_name'=>'api'],

            ['name'=>'slides.index', 'zh_name'=>'轮播图列表', 'guard_name'=>'api'],
            ['name'=>'slides.store', 'zh_name'=>'轮播图添加', 'guard_name'=>'api'],
            ['name'=>'slides.show', 'zh_name'=>'轮播图详情', 'guard_name'=>'api'],
            ['name'=>'slides.update', 'zh_name'=>'轮播图更新', 'guard_name'=>'api'],
            ['name'=>'slides.destroy', 'zh_name'=>'轮播图删除', 'guard_name'=>'api'],


        ];

//        Permission::insert($permissions);
        foreach ($permissions as $p){
            Permission::create($p);
        }

        // 添加超级管理员
        $roles = ['name'=>'root', 'zh_name'=>'超级管理员', 'guard_name'=>'api'];
        $role = Role::create($roles);

        // 为超级管理员添加权限
        $role->givePermissionTo(Permission::all());

        // 分类管理员
        $roles = ['name'=>'admin_category', 'zh_name'=>'分类管理员', 'guard_name'=>'api'];
        $role = Role::create($roles);
        // 给角色添加权限，只能一个一个加吗？
        $permissions = ['category.index', 'category.store', 'category.store', 'category.update', 'category.status'];

        $role->givePermissionTo($permissions);
    }
}
