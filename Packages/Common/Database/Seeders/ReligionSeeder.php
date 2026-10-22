<?php

namespace Packages\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Packages\Common\Models\Religion;

class ReligionSeeder extends Seeder
{
    public function run()
    {
        Religion::create(['name' => 'الإسلام']);
        Religion::create(['name' => 'المسيحية']);
        Religion::create(['name' => 'اليهودية']);
    }
}
