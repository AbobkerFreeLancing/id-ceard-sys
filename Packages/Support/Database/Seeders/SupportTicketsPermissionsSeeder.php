<?php

namespace Packages\Support\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SupportTicketsPermissionsSeeder extends Seeder
{
    public function run()
    {
        Permission::create([
            'name' => 'support_ticket_management',
            'label' => 'Support Ticket Management',
            'label_ar' => 'إدارة تذاكر الدعم الفني',
        ]);

        Permission::create([
            'name' => 'support_ticket_assign_management',
            'label' => 'Support Ticket Assign Management',
            'label_ar' => 'اسناد تذاكر الدعم الفني',
        ]);

        Permission::create([
            'name' => 'support_ticket_categories_management',
            'label' => 'Support Ticket Categories Management',
            'label_ar' => 'إدارة تصنيفات تذاكر الدعم',
        ]);
    }
}
