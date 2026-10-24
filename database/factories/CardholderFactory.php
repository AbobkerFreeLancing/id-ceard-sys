<?php

namespace Database\Factories;

use App\Models\Cardholder;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cardholder>
 */
class CardholderFactory extends Factory
{
    protected $model = Cardholder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'department_id' => Department::factory(),
            'full_name_ar' => fake('ar_SA')->name(),
            'full_name_en' => fake()->name(),
            'national_id' => fake()->unique()->numerify('1##########'),
            'employee_no' => fake()->numerify('EMP-####'),
            'blood_type' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'photo_path' => null,
            'signature_path' => null,
            'extra_data' => [
                'phone' => fake()->phoneNumber(),
                'email' => fake()->safeEmail(),
                'birth_date' => fake()->date('Y-m-d', '-20 years'),
            ],
        ];
    }
}
