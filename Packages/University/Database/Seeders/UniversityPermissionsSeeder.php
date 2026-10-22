<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UniversityPermissionsSeeder extends Seeder
{
    public function run()
    {
        Permission::create([
            'name' => 'college_management',
            'label' => 'College Management',
            'label_ar' => 'إدارة الكليات',
        ]);

        Permission::create([
            'name' => 'department_management',
            'label' => 'Department Management',
            'label_ar' => 'إدارة الأقسام',
        ]);

        Permission::create([
            'name' => 'study_year_management',
            'label' => 'Study Years Management',
            'label_ar' => 'إدارة السنوات الدراسية',
        ]);

        Permission::create([
            'name' => 'level_management',
            'label' => 'Levels Management',
            'label_ar' => 'إدارة المستويات الأكاديمية',
        ]);

        Permission::create([
            'name' => 'division_management',
            'label' => 'Divisions Management',
            'label_ar' => 'إدارة التخصصات',
        ]);

        Permission::create([
            'name' => 'course_management',
            'label' => 'courses Management',
            'label_ar' => 'إدارة المقررات',
        ]);

        Permission::create([
            'name' => 'student_management',
            'label' => 'students Management',
            'label_ar' => 'إدارة الطلاب',
        ]);

        Permission::create([
            'name' => 'student_management',
            'label' => 'students Management',
            'label_ar' => 'إدارة الطلاب',
        ]);

        Permission::create([
            'name' => 'import_students_from_excal',
            'label' => 'Import Students From Excal',
            'label_ar' => 'إستيراد الطلاب من ملف إكسل',
        ]);

        Permission::create([
            'name' => 'fee_structure_management',
            'label' => 'Fee Structures Management',
            'label_ar' => 'إدارة هيكل الرسوم',
        ]);

        Permission::create([
            'name' => 'batch_management',
            'label' => 'Batch Management',
            'label_ar' => 'إدارة الدفعات',
        ]);

        Permission::create([
            'name' => 'batch_transition_management',
            'label' => 'Batch Transitions Management',
            'label_ar' => 'إدارة نقل الدفعات',
        ]);

        Permission::create([
            'name' => 'medical_checkup_management',
            'label' => 'Medical Checkup Management',
            'label_ar' => 'إدارة سجلات الكشف الطبي',
        ]);

        Permission::create([
            'name' => 'student_interviews_management',
            'label' => 'Student Interviews Management',
            'label_ar' => 'إدارة معاينات الطلاب',
        ]);

        Permission::create([
            'name' => 'student_charges_management',
            'label' => 'Student Charges Management',
            'label_ar' => 'إدارة استحقاقات الطلاب',
        ]);

        Permission::create([
            'name' => 'certificate_requests_management',
            'label' => 'Certificate Requests Management',
            'label_ar' => 'إدارة طلبات الشهادات',
        ]);

        Permission::create([
            'name' => 'university_id_cards_management',
            'label' => 'University ID Cards Management',
            'label_ar' => 'إدارة بطاقات الطلاب',
        ]);
    }
}
