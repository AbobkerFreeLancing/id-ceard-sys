<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\FeeType;

class FeeTypeSeeder extends Seeder
{
    public function run()
    {
        FeeType::create([
            'name' => 'رسوم التسجيل',
            'name_en' => 'Registration Fees',
            'code' => 'registration_fees',
            'sort_order' => 1,
        ]);

        FeeType::create([
            'name' => 'الرسوم الدراسية',
            'name_en' => 'Tuition fees',
            'code' => 'tuition_fees',
            'sort_order' => 2,
        ]);

        FeeType::create([
            'name' => 'رسوم الكشف الطبي',
            'name_en' => 'Medical Checkup Fees',
            'code' => 'medical_checkup_fees',
            'sort_order' => 3,
        ]);

        FeeType::create([
            'name' => 'رسوم النشاط الطلابي',
            'name_en' => 'Student Activity Fees',
            'code' => 'student_activity_fees',
            'sort_order' => 4,
        ]);

        FeeType::create([
            'name' => 'رسوم التأمين الصحي',
            'name_en' => 'Health Insurance Fee',
            'code' => 'health_insurance_fees',
            'sort_order' => 5,
        ]);

        FeeType::create([
            'name' => 'رسوم السكن الجامعي',
            'name_en' => 'Housing Fees',
            'code' => 'housing_fees',
            'is_active' => false,
            'sort_order' => 6,
        ]);

        FeeType::create([
            'name' => 'رسوم المكتبة',
            'name_en' => 'Library Fees',
            'code' => 'library_fees',
            'sort_order' => 7,
            'is_active' => false,
        ]);

        FeeType::create([
            'name' => 'رسوم حفل التخرج',
            'name_en' => 'Graduation Ceremony Fees',
            'code' => 'graduation_ceremony_fees',
            'is_mandatory' => false,
            'is_active' => false,
            'sort_order' => 8,
        ]);
    }
}
