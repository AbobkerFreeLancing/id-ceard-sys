<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ksu = Organization::where('code', 'KSU')->first();
        $hospital = Organization::where('code', 'KFSH')->first();

        if ($ksu) {
            $ccis = Department::firstOrCreate(
                ['organization_id' => $ksu->id, 'name_ar' => 'كلية علوم الحاسب والمعلومات'],
                [
                    'name_en' => 'College of Computer and Information Sciences',
                    'type' => 'كلية',
                    'parent_id' => null,
                    'path' => '/1/',
                    'depth' => 0,
                ]
            );

            Department::firstOrCreate(
                ['organization_id' => $ksu->id, 'name_ar' => 'قسم هندسة البرمجيات'],
                [
                    'name_en' => 'Software Engineering Department',
                    'type' => 'قسم',
                    'parent_id' => $ccis->id,
                    'path' => '/1/'.$ccis->id.'/',
                    'depth' => 1,
                ]
            );

            Department::firstOrCreate(
                ['organization_id' => $ksu->id, 'name_ar' => 'قسم علوم الحاسب'],
                [
                    'name_en' => 'Computer Science Department',
                    'type' => 'قسم',
                    'parent_id' => $ccis->id,
                    'path' => '/1/'.$ccis->id.'/',
                    'depth' => 1,
                ]
            );
        }

        if ($hospital) {
            Department::firstOrCreate(
                ['organization_id' => $hospital->id, 'name_ar' => 'إدارة الطوارئ والعناية المركزة'],
                [
                    'name_en' => 'Emergency & ICU Department',
                    'type' => 'إدارة',
                    'parent_id' => null,
                    'path' => '/2/',
                    'depth' => 0,
                ]
            );
        }
    }
}
