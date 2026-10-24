<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'parent_id' => null,
            'type' => fake()->randomElement(['إدارة', 'كلية', 'قسم', 'وحدة', 'شعبة']),
            'name_ar' => fake('ar_SA')->words(2, true),
            'name_en' => fake()->words(2, true),
            'path' => null,
            'depth' => 0,
        ];
    }
}
