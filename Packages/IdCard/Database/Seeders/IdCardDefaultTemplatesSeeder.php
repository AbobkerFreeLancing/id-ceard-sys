<?php

namespace Packages\IdCard\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\IdCard\Enums\CardOrientationEnum;
use Packages\IdCard\Enums\CardTypeEnum;
use Packages\IdCard\Models\CardTemplate;
use Packages\IdCard\Models\Department;
use Packages\IdCard\Models\Organization;

class IdCardDefaultTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default Organization
        $org = Organization::firstOrCreate(
            ['code' => 'ORG-MAIN'],
            [
                'name' => 'المؤسسة الرئيسية / الجامعة الذكية',
                'website' => 'https://example.com',
                'contact_email' => 'info@example.com',
                'is_active' => true,
            ]
        );

        // 2. Create Hierarchical Expandable Department Tree (هيكل أقسام وتصنيفات شبكية)
        // المستوى 0: قطاع رئيسي
        $sector = Department::firstOrCreate(
            ['code' => 'IT-SECTOR', 'organization_id' => $org->id],
            [
                'name' => 'قطاع تقنية المعلومات والتحول الرقمي',
                'classification' => 'sector',
                'depth_level' => 0,
                'color_hex' => '#00a6f4',
            ]
        );

        // المستوى 1: إدارة عامة متفرعة
        $dept1 = Department::firstOrCreate(
            ['code' => 'DEV-DEPT', 'organization_id' => $org->id, 'parent_id' => $sector->id],
            [
                'name' => 'إدارة تطوير النظم والتطبيقات',
                'classification' => 'division',
                'depth_level' => 1,
                'color_hex' => '#16a34a',
            ]
        );

        // المستوى 2: وحدة / قسم فرعي
        $dept2 = Department::firstOrCreate(
            ['code' => 'SYS-UNIT', 'organization_id' => $org->id, 'parent_id' => $dept1->id],
            [
                'name' => 'قسم أمن البطاقات والهويات الذكية',
                'classification' => 'unit',
                'depth_level' => 2,
                'color_hex' => '#6366f1',
            ]
        );

        // 3. Create Default Card Template (CR80 Standard)
        $template = CardTemplate::firstOrCreate(
            ['name' => 'القالب القياسي للبطاقات الذكية - أفقي', 'organization_id' => $org->id],
            [
                'card_type' => CardTypeEnum::Student,
                'orientation' => CardOrientationEnum::Landscape,
                'width_mm' => 85.60,
                'height_mm' => 53.98,
                'is_active' => true,
            ]
        );

        // 4. Default Template Elements (Front)
        $elements = [
            ['element_key' => 'photo', 'label' => 'الصورة الشخصية', 'pos_x_mm' => 6.0, 'pos_y_mm' => 12.0, 'width_mm' => 22.0, 'height_mm' => 28.0],
            ['element_key' => 'full_name', 'label' => 'الاسم الكامل', 'pos_x_mm' => 32.0, 'pos_y_mm' => 14.0, 'font_size_pt' => 11.0, 'font_weight' => 'bold', 'color_hex' => '#111827'],
            ['element_key' => 'identifier_code', 'label' => 'الرقم الأكاديمي/الوظيفي', 'pos_x_mm' => 32.0, 'pos_y_mm' => 22.0, 'font_size_pt' => 9.5, 'color_hex' => '#4b5563'],
            ['element_key' => 'department', 'label' => 'القسم / الكلية', 'pos_x_mm' => 32.0, 'pos_y_mm' => 30.0, 'font_size_pt' => 9.0, 'color_hex' => '#4b5563'],
            ['element_key' => 'qr_code', 'label' => 'رمز الاستجابة السريع QR', 'pos_x_mm' => 65.0, 'pos_y_mm' => 32.0, 'width_mm' => 16.0, 'height_mm' => 16.0],
        ];

        foreach ($elements as $el) {
            $template->elements()->firstOrCreate(
                ['element_key' => $el['element_key'], 'side' => 'front'],
                $el
            );
        }
    }
}
