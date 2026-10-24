<?php

namespace Database\Seeders;

use App\Models\Cardholder;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CardholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ksu = Organization::where('code', 'KSU')->first();
        $hospital = Organization::where('code', 'KFSH')->first();

        $seDept = Department::where('name_ar', 'قسم هندسة البرمجيات')->first();
        $medDept = Department::where('name_ar', 'إدارة الطوارئ والعناية المركزة')->first();

        if ($ksu && $seDept) {
            Cardholder::firstOrCreate(
                ['national_id' => '1098765432'],
                [
                    'organization_id' => $ksu->id,
                    'department_id' => $seDept->id,
                    'full_name_ar' => 'عبدالرحمن محمد الدوسري',
                    'full_name_en' => 'Abdulrahman Mohammed Al-Dossari',
                    'employee_no' => 'STU-44101',
                    'blood_type' => 'O+',
                    'photo_path' => 'photos/cardholders/holder1.jpg',
                    'extra_data' => [
                        'phone' => '+966501112233',
                        'email' => 'a.dossari@student.ksu.edu.sa',
                        'level' => 'المستوى الثامن',
                    ],
                ]
            );

            Cardholder::firstOrCreate(
                ['national_id' => '1087654321'],
                [
                    'organization_id' => $ksu->id,
                    'department_id' => $seDept->id,
                    'full_name_ar' => 'سارة عبدالعزيز القحطاني',
                    'full_name_en' => 'Sara Abdulaziz Al-Qahtani',
                    'employee_no' => 'STU-44102',
                    'blood_type' => 'A+',
                    'photo_path' => 'photos/cardholders/holder2.jpg',
                    'extra_data' => [
                        'phone' => '+966502223344',
                        'email' => 's.qahtani@student.ksu.edu.sa',
                        'level' => 'المستوى السادس',
                    ],
                ]
            );
        }

        if ($hospital && $medDept) {
            Cardholder::firstOrCreate(
                ['national_id' => '1023456789'],
                [
                    'organization_id' => $hospital->id,
                    'department_id' => $medDept->id,
                    'full_name_ar' => 'د. خالد إبراهيم الشمري',
                    'full_name_en' => 'Dr. Khaled Ibrahim Al-Shammari',
                    'employee_no' => 'DOC-9081',
                    'blood_type' => 'B+',
                    'photo_path' => 'photos/cardholders/holder3.jpg',
                    'signature_path' => 'signatures/holder3.png',
                    'extra_data' => [
                        'specialty' => 'استشاري عناية مركزة وجراحة طوارئ',
                        'phone' => '+966503334455',
                        'email' => 'k.shammari@kfsh.med.sa',
                    ],
                ]
            );

            Cardholder::firstOrCreate(
                ['national_id' => '1034567890'],
                [
                    'organization_id' => $hospital->id,
                    'department_id' => $medDept->id,
                    'full_name_ar' => 'مها فهد العتيبي',
                    'full_name_en' => 'Maha Fahad Al-Otaibi',
                    'employee_no' => 'NUR-4120',
                    'blood_type' => 'AB+',
                    'photo_path' => 'photos/cardholders/holder4.jpg',
                    'extra_data' => [
                        'specialty' => 'أخصائية تمريض عام',
                        'phone' => '+966504445566',
                        'email' => 'm.otaibi@kfsh.med.sa',
                    ],
                ]
            );
        }
    }
}
