<?php

namespace Packages\Common\Database\Seeders;

use Packages\Common\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    public function run(): void
    {
        $interests = [
            ['name' => 'القرآن', 'slug' => 'quran'],
            ['name' => 'حفظ القرآن', 'slug' => 'memorizing-quran'],
            ['name' => 'طلب العلم الشرعي', 'slug' => 'islamic-studies'],
            ['name' => 'القراءة', 'slug' => 'reading'],
            ['name' => 'السفر', 'slug' => 'travel'],
            ['name' => 'الرياضة', 'slug' => 'sports'],
            ['name' => 'المشي', 'slug' => 'walking'],
            ['name' => 'التطوع', 'slug' => 'volunteering'],
            ['name' => 'الطبخ', 'slug' => 'cooking'],
            ['name' => 'الأسرة', 'slug' => 'family'],
            ['name' => 'تربية الأطفال', 'slug' => 'parenting'],
            ['name' => 'التقنية', 'slug' => 'technology'],
            ['name' => 'البرمجة', 'slug' => 'programming'],
            ['name' => 'ريادة الأعمال', 'slug' => 'entrepreneurship'],
            ['name' => 'التجارة', 'slug' => 'business'],
            ['name' => 'الزراعة', 'slug' => 'agriculture'],
            ['name' => 'الأعمال اليدوية', 'slug' => 'handcrafts'],
            ['name' => 'التصوير', 'slug' => 'photography'],
            ['name' => 'الرسم', 'slug' => 'drawing'],
            ['name' => 'الكتابة', 'slug' => 'writing'],
            ['name' => 'الشعر', 'slug' => 'poetry'],
            ['name' => 'اللغات', 'slug' => 'languages'],
            ['name' => 'التعليم', 'slug' => 'education'],
            ['name' => 'الأعمال الخيرية', 'slug' => 'charity'],
            ['name' => 'الحيوانات الأليفة', 'slug' => 'pets'],
            ['name' => 'التخييم', 'slug' => 'camping'],
            ['name' => 'القهوة', 'slug' => 'coffee'],
            ['name' => 'الألعاب الإلكترونية', 'slug' => 'video-games'],
            ['name' => 'الأعمال المنزلية', 'slug' => 'housework'],
        ];

        foreach ($interests as $index => $interest) {
            Interest::updateOrCreate(
                ['slug' => $interest['slug']],
                [
                    'name' => $interest['name'],
                    'slug' => $interest['slug'],
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}
