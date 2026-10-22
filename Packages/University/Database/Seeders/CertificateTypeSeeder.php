<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\CertificateType;

class CertificateTypeSeeder extends Seeder
{
    public function run()
    {
        $certificates = [
            // Graduation Certificates
            [
                'name' => 'إفادة تخرج',
                'name_en' => 'Graduation Certificate',
                'code' => 'graduation_ar',
            ],
            [
                'name' => 'إفادة تخرج (إنجليزي)',
                'name_en' => 'Graduation Certificate (English)',
                'code' => 'graduation_en',
            ],
            [
                'name' => 'تفاصيل التخرج',
                'name_en' => 'Graduation Details',
                'code' => 'graduation_details_ar',
            ],
            [
                'name' => 'تفاصيل التخرج (إنجليزي)',
                'name_en' => 'Graduation Details (English)',
                'code' => 'graduation_details_en',
            ],

            // Enrollment Certificates
            [
                'name' => 'شهادة قيد',
                'name_en' => 'Enrollment Certificate',
                'code' => 'enrollment_ar',
            ],
            [
                'name' => 'شهادة قيد (إنجليزي)',
                'name_en' => 'Enrollment Certificate (English)',
                'code' => 'enrollment_en',
            ],
            [
                'name' => 'إفادة دراسة',
                'name_en' => 'Study Certificate',
                'code' => 'study_ar',
            ],
            [
                'name' => 'إفادة دراسة (إنجليزي)',
                'name_en' => 'Study Certificate (English)',
                'code' => 'study_en',
            ],

            // Transcripts
            [
                'name' => 'كشف درجات',
                'name_en' => 'Transcript',
                'code' => 'transcript_ar',
            ],
            [
                'name' => 'كشف درجات (إنجليزي)',
                'name_en' => 'Transcript (English)',
                'code' => 'transcript_en',
            ],
            [
                'name' => 'تفاصيل الكشف',
                'name_en' => 'Transcript Details',
                'code' => 'transcript_details_ar',
            ],
            [
                'name' => 'تفاصيل الكشف (إنجليزي)',
                'name_en' => 'Transcript Details (English)',
                'code' => 'transcript_details_en',
            ],

            // Other Certificates
            [
                'name' => 'شهادة حسن سير وسلوك',
                'name_en' => 'Good Conduct Certificate',
                'code' => 'good_conduct_ar',
            ],
            [
                'name' => 'شهادة حسن سير وسلوك (إنجليزي)',
                'name_en' => 'Good Conduct Certificate (English)',
                'code' => 'good_conduct_en',
            ],
            [
                'name' => 'شهادة مالية',
                'name_en' => 'Financial Certificate',
                'code' => 'financial_ar',
            ],
            [
                'name' => 'شهادة مالية (إنجليزي)',
                'name_en' => 'Financial Certificate (English)',
                'code' => 'financial_en',
            ],
            [
                'name' => 'شهادة مزدوجة (عربي/إنجليزي)',
                'name_en' => 'Dual Certificate (Arabic/English)',
                'code' => 'dual_certificate',
            ],
        ];

        foreach ($certificates as $certificate) {
            CertificateType::create($certificate);
        }
    }
}
