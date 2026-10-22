<?php

namespace Packages\IdCard\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class IdCardPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Organizations & Departments
            'manage_idcard_organizations',
            'manage_idcard_departments',

            // Templates
            'view_card_templates',
            'create_card_templates',
            'edit_card_templates',
            'delete_card_templates',

            // Cardholders
            'view_cardholders',
            'create_cardholders',
            'edit_cardholders',
            'delete_cardholders',
            'import_cardholders',

            // Cards & Printing
            'view_cards',
            'issue_cards',
            'approve_cards',
            'print_cards',
            'revoke_cards',
            'manage_card_batches',

            // Verification & Scanner
            'verify_cards',
            'view_verification_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign to Super Admin if exists
        $adminRole = Role::where('name', 'Super Admin')->orWhere('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }
    }
}
