<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@huwia.test'],
            [
                'name' => 'مدير النظام (Admin)',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'security@huwia.test'],
            [
                'name' => 'أحمد - مسؤول الأمن (Security)',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
