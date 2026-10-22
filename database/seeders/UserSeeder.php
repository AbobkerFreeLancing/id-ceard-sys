<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::withoutEvents(function () {
            // Mustafa Online
            $online = User::create([
                'name' => 'مصطفى أونلاين',
                'email' => 'sawdjg@gmail.com',
                'phone' => '1234567899',
                'email_verified_at' => now(),
                'password' => bcrypt('sawdjg@gmail.com1'),
                'address' => 'Sudan, Khartoum',
                'remember_token' => Str::random(10),
            ]);

            $online->assignRole('dev');
            $online->save();

            // ------------ Admin ------
            $admin = User::create([
                'name' => 'Admin Account',
                'email' => 'admin@email.dev',
                'phone' => random_int(1111111111, 9999999999),
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
                'address' => 'Everywhere',
                'remember_token' => Str::random(10),
            ]);

            $admin->assignRole('admin');
            $admin->save();

            // ------------ Admin ------
            $user = User::create([
                'name' => 'Mohammed Ameer',
                'email' => 'mohammed@email.dev',
                'phone' => '1234123400',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
                'address' => 'Sudan',
                'remember_token' => Str::random(10),
            ]);

            $user->assignRole('admin');
            $user->save();
            // ------------ Abo Bakr ------
            $user = User::create([
                'name' => 'Abobker',
                'email' => 'Abobker@email.dev',
                'phone' => '1994123880',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
                'address' => 'Sudan',
                'remember_token' => Str::random(10),
            ]);

            $user->assignRole('admin');
            $user->save();
        }); // end without events
    }
}
