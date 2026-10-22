<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run()
    {
        State::create(['name' => 'ولاية الخرطوم']);
        State::create(['name' => 'ولاية الجزيرة']);
        State::create(['name' => 'ولاية نهر النيل']);
        State::create(['name' => 'الولاية الشمالية']);
        State::create(['name' => 'ولاية البحر الأحمر']);
        State::create(['name' => 'ولاية كسلا']);
        State::create(['name' => 'ولاية القضارف']);
        State::create(['name' => 'ولاية سنار']);
        State::create(['name' => 'ولاية النيل الأزرق']);
        State::create(['name' => 'ولاية النيل الأبيض']);
        State::create(['name' => 'ولاية شمال كردفان']);
        State::create(['name' => 'ولاية جنوب كردفان']);
        State::create(['name' => 'ولاية غرب كردفان']);
        State::create(['name' => 'ولاية شمال دارفور']);
        State::create(['name' => 'ولاية جنوب دارفور']);
        State::create(['name' => 'ولاية غرب دارفور']);
        State::create(['name' => 'ولاية وسط دارفور']);
        State::create(['name' => 'ولاية شرق دارفور']);
    }
}
