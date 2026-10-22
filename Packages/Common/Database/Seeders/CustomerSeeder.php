<?php

namespace Packages\Common\Database\Seeders;

use App\Models\User;
use Packages\Enum\Profile\UserTypeEnum;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'عميل افتراضي',
            'phone' => random_int(1111111111, 9999999999),
            'email' => 'customer@system.com',
            'password' => bcrypt(random_int(1111, 9999) . 'password'),
            'type' => UserTypeEnum::Customer->value,
        ]);

        $user->customer()->create([
            'branch_id' => 1,
        ]);
    }
}
