<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => fake('ar_SA')->company(),
            'name_en' => fake()->company(),
            'code' => strtoupper(fake()->unique()->lexify('???')),
            'logo_path' => null,
            'settings' => [
                'card_validity_years' => 1,
                'primary_color' => '#1e40af',
                'language' => 'ar',
            ],
            'is_active' => true,
        ];
    }
}
