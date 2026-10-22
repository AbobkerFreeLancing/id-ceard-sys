<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Roles
        Permission::create(['name' => 'role_management', 'label' => 'Roles Management', 'label_ar' => 'إدارة الوظائف']);

        // Settings
        Permission::create(['name' => 'settings_management', 'label' => 'Settings Management', 'label_ar' => 'إدارة الإعدادات']);

        // Staff (Users)
        Permission::create(['name' => 'user_management', 'label' => 'User Management', 'label_ar' => 'إدارة المستخدمين']);
    }
}