<?php

namespace Database\Seeders;

use App\Enums\TemplateOrientation;
use App\Models\CardTemplate;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CardTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ksu = Organization::where('code', 'KSU')->first();
        $hospital = Organization::where('code', 'KFSH')->first();

        if ($ksu) {
            CardTemplate::firstOrCreate(
                ['organization_id' => $ksu->id, 'name' => 'بطاقة طالب أفقية (Standard CR80)'],
                [
                    'orientation' => TemplateOrientation::Landscape,
                    'width_mm' => 85.60,
                    'height_mm' => 54.00,
                    'dpi' => 300,
                    'front_bg' => 'templates/ksu-student-front.png',
                    'back_bg' => 'templates/ksu-student-back.png',
                    'layout' => [
                        'elements' => [
                            ['id' => 'photo', 'type' => 'photo', 'x' => 8, 'y' => 12, 'w' => 25, 'h' => 32],
                            ['id' => 'name_ar', 'type' => 'text', 'x' => 38, 'y' => 14, 'fontSize' => 14, 'font' => 'Cairo-Bold'],
                            ['id' => 'name_en', 'type' => 'text', 'x' => 38, 'y' => 20, 'fontSize' => 11, 'font' => 'Inter-Medium'],
                            ['id' => 'national_id', 'type' => 'text', 'x' => 38, 'y' => 26, 'fontSize' => 10],
                            ['id' => 'qr', 'type' => 'qr', 'x' => 65, 'y' => 28, 'w' => 16, 'h' => 16],
                        ],
                    ],
                ]
            );
        }

        if ($hospital) {
            CardTemplate::firstOrCreate(
                ['organization_id' => $hospital->id, 'name' => 'بطاقة كادر طبي رأسية (Vertical Medical)'],
                [
                    'orientation' => TemplateOrientation::Portrait,
                    'width_mm' => 54.00,
                    'height_mm' => 85.60,
                    'dpi' => 300,
                    'front_bg' => 'templates/kfsh-doctor-front.png',
                    'back_bg' => null,
                    'layout' => [
                        'elements' => [
                            ['id' => 'photo', 'type' => 'photo', 'x' => 12, 'y' => 15, 'w' => 30, 'h' => 38],
                            ['id' => 'name_ar', 'type' => 'text', 'x' => 5, 'y' => 58, 'fontSize' => 13, 'align' => 'center'],
                            ['id' => 'blood_type', 'type' => 'badge', 'x' => 20, 'y' => 66, 'color' => '#dc2626'],
                            ['id' => 'qr', 'type' => 'qr', 'x' => 17, 'y' => 71, 'w' => 20, 'h' => 20],
                        ],
                    ],
                ]
            );
        }
    }
}
