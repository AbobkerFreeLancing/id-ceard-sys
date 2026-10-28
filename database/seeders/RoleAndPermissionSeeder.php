<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions list
        $permissions = [
            'cardholders.view_any',
            'cardholders.create',
            'cardholders.update',
            'cardholders.delete',
            'cardholders.audit',
            'cards.view_any',
            'cards.create',
            'cards.issue',
            'cards.revoke',
            'batches.view_any',
            'batches.create',
            'batches.print',
            'organizations.manage',
            'templates.manage',
            'verifications.scan',
            'verifications.view_logs',
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 1. Super Admin
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // 2. Org Manager
        $orgManager = Role::firstOrCreate(['name' => 'org_manager', 'guard_name' => 'web']);
        $orgManager->givePermissionTo([
            'cardholders.view_any',
            'cardholders.create',
            'cardholders.update',
            'cards.view_any',
            'batches.view_any',
            'batches.create',
            'templates.manage',
            'verifications.view_logs',
            'reports.view',
        ]);

        // 3. Data Collector
        $dataCollector = Role::firstOrCreate(['name' => 'data_collector', 'guard_name' => 'web']);
        $dataCollector->givePermissionTo([
            'cardholders.view_any',
            'cardholders.create',
            'cardholders.update',
        ]);

        // 4. Data Auditor
        $dataAuditor = Role::firstOrCreate(['name' => 'data_auditor', 'guard_name' => 'web']);
        $dataAuditor->givePermissionTo([
            'cardholders.view_any',
            'cardholders.audit',
            'cards.view_any',
            'cards.create',
        ]);

        // 5. Print Operator
        $printOperator = Role::firstOrCreate(['name' => 'print_operator', 'guard_name' => 'web']);
        $printOperator->givePermissionTo([
            'cards.view_any',
            'cards.issue',
            'batches.view_any',
            'batches.create',
            'batches.print',
        ]);

        // 6. Security Officer
        $securityOfficer = Role::firstOrCreate(['name' => 'security_officer', 'guard_name' => 'web']);
        $securityOfficer->givePermissionTo([
            'verifications.scan',
            'verifications.view_logs',
            'cards.view_any',
        ]);

        // Assign Super Admin role to the first user if exists
        $firstUser = User::first();
        if ($firstUser) {
            $firstUser->assignRole($superAdmin);
        }
    }
}
