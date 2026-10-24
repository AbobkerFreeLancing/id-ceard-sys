<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::firstOrCreate(
            ['code' => 'KSU'],
            [
                'name_ar' => 'جامعة الملك سعود',
                'name_en' => 'King Saud University',
                'logo_path' => 'organizations/ksu-logo.png',
                'settings' => [
                    'card_validity_years' => 4,
                    'primary_color' => '#0284c7',
                    'language' => 'ar',
                ],
                'is_active' => true,
            ]
        );

        Organization::firstOrCreate(
            ['code' => 'KFSH'],
            [
                'name_ar' => 'مستشفى الملك فيصل التخصصي',
                'name_en' => 'King Faisal Specialist Hospital',
                'logo_path' => 'organizations/kfsh-logo.png',
                'settings' => [
                    'card_validity_years' => 2,
                    'primary_color' => '#059669',
                    'language' => 'ar',
                ],
                'is_active' => true,
            ]
        );
    }
}
