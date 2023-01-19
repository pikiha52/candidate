<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // role
        $roleSenior = Role::create(['name' => 'Senior HRD']);
        $roleHr = Role::create(['name' => 'HRD']);

        // permission
        $permissionView = Permission::create(['name' => 'view']);
        $permissionRead = Permission::create(['name' => 'read']);
        $permissionEdit = Permission::create(['name' => 'edit']);
        $permissionAdd = Permission::create(['name' => 'add']);
        $permissionDelete = Permission::create(['name' => 'delete']);

        $roleSenior->givePermissionTo([$permissionView, $permissionAdd, $permissionEdit, $permissionDelete]);
        $roleHr->givePermissionTo([$permissionView, $permissionRead]);

        $user1 = User::find(1);
        $user2 = User::find(2);

        $user1->givePermissionTo($permissionView->name, $permissionRead->name, $permissionEdit, $permissionAdd, $permissionDelete);
        $user2->givePermissionTo($permissionView->name, $permissionRead->name);
    }
}
