<?php

namespace Packages\University\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\University\Models\AcceptanceType;

class AcceptanceTypeSeeder extends Seeder
{
    public function run()
    {
        AcceptanceType::create([
            'name' => 'عام',
            'name_en' => 'General',
            'code' => 'gen',
        ]);

        AcceptanceType::create([
            'name' => 'موازي',
            'name_en' => 'pp',
            'code' => 'pp',
        ]);

        AcceptanceType::create([
            'name' => 'نفقة خاصة',
            'name_en' => 'private',
            'code' => 'private',
        ]);

        AcceptanceType::create([
            'name' => 'وافدين',
            'name_en' => 'cc',
            'code' => 'cc',
        ]);
    }
}
