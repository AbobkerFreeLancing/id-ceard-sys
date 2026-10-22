<?php

namespace Packages\Accounting\Database\Seeders;

use Packages\Accounting\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run()
    {
        Bank::create([
            'name' => 'بنك الخرطوم',
            'name_en' => 'Bank of Khartoum',
            'code' => 'BOK',
            'is_enabled' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Bank::create([
            'name' => 'بنك فيصل الإسلامي',
            'name_en' => 'Faisal Islamic Bank',
            'code' => 'FIB',
            'is_enabled' => true,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Bank::create([
            'name' => 'بنك أمدرمان الوطني',
            'name_en' => 'Omdurman National Bank',
            'code' => 'ONB',
            'is_enabled' => true,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        Bank::create([
            'name' => 'بنك البركة',
            'name_en' => 'Al-Baraka Bank',
            'code' => 'BARAKA',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 4,
        ]);

        Bank::create([
            'name' => 'بنك النيل',
            'name_en' => 'Nile Bank',
            'code' => 'NILE',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 5,
        ]);

        Bank::create([
            'name' => 'بنك النيل الأزرق المشرق',
            'name_en' => 'Mashreq Bank',
            'code' => 'MASHREQ',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 6,
        ]);

        Bank::create([
            'name' => 'البنك الزراعي',
            'name_en' => 'Ziraee Bank',
            'code' => 'ZIRAEE',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 7,
        ]);

        Bank::create([
            'name' => 'بنك الادخار',
            'name_en' => 'Edikhar Bank',
            'code' => 'EDIKHAR',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 8,
        ]);

        Bank::create([
            'name' => 'بنك تنمية الصادرات',
            'name_en' => 'Tanmiat Saderat Bank',
            'code' => 'TANMIA',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 9,
        ]);

        Bank::create([
            'name' => 'بنك الثروة الحيوانية',
            'name_en' => 'Tharwa Bank',
            'code' => 'THARWA',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 10,
        ]);

        Bank::create([
            'name' => 'مصرف السلام',
            'name_en' => 'Al-Salam Bank',
            'code' => 'SALAM',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 11,
        ]);

        Bank::create([
            'name' => 'بنك المال المتحد',
            'name_en' => 'United Bank',
            'code' => 'MAL',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 12,
        ]);

        Bank::create([
            'name' => 'مصرف البلد',
            'name_en' => 'Al-Balad Bank',
            'code' => 'BALAD',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 13,
        ]);

        Bank::create([
            'name' => 'بنك العمال الوطني',
            'name_en' => 'National Workers Bank',
            'code' => 'NWB',
            'is_enabled' => false,
            'is_active' => false,
            'sort_order' => 14,
        ]);
    }
}
