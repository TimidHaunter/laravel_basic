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
        ];

//        Permission::insert($permissions);
        foreach ($permissions as $p){
            Permission::create($p);
        }

        // 添加角色
        $roles = ['name'=>'super_admin', 'zh_name'=>'超级管理员', 'guard_name'=>'api'];
        $role = Role::create($roles);

        // 为角色添加权限
        $role->givePermissionTo(Permission::all());
    }
}
