<?php

namespace Packages\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $file_path = database_path('seeders/countries.sql');

        DB::unprepared(file_get_contents($file_path));
    }
}
