<?php

namespace Packages\Support\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\Support\Models\TicketCategory;

class TicketCategorySeeder extends Seeder
{
    public function run()
    {
        TicketCategory::create([
            'name' => 'الشؤون المالية',
            'slug' => 'finance',
            'description' => '',
        ]);

        TicketCategory::create([
            'name' => 'التسجيل الأكاديمي والمقررات',
            'slug' => 'academic-registration',
            'description' => '',
        ]);

        TicketCategory::create([
            'name' => 'الشكاوى والمقترحات العامة',
            'slug' => 'general-inquiries',
            'description' => '',
        ]);

        TicketCategory::create([
            'name' => 'طلب دعم فني',
            'slug' => 'support',
            'description' => '',
        ]);
    }
}
