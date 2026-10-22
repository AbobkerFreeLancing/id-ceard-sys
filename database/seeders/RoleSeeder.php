<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $all_permissions = Permission::all();

        // Dev
        $dev = Role::create(['name' => 'dev', 'description' => 'Developer']);
        $dev->givePermissionTo($all_permissions);

        // Admin
        $admin = Role::create(['name' => 'admin', 'description' => 'مدير النظام']);
        $admin->givePermissionTo($all_permissions);

        // Employee
        $employee = Role::create(['name' => 'employee', 'description' => 'موظف']);
        $employee->givePermissionTo($all_permissions);

        // Accountant
        $accountant = Role::create(['name' => 'accountant', 'description' => 'المحاسب']);
        $accountant->givePermissionTo($all_permissions);

        // finance_manager
        $finance_manager = Role::create(['name' => 'finance_manager', 'description' => 'مدير الشؤون المالية']);
        $finance_manager->givePermissionTo($all_permissions);

        // Employee Non
        $employee_non = Role::create(['name' => 'employee_non', 'description' => 'موظف بدون صلاحيات']);
        $employee_non->givePermissionTo([]);
    }
}
