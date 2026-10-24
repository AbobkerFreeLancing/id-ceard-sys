<?php

namespace Database\Factories;

use App\Enums\TemplateOrientation;
use App\Models\CardTemplate;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CardTemplate>
 */
class CardTemplateFactory extends Factory
{
    protected $model = CardTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'name' => fake('ar_SA')->words(3, true),
            'orientation' => TemplateOrientation::Landscape,
            'width_mm' => 85.60,
            'height_mm' => 54.00,
            'dpi' => 300,
            'front_bg' => null,
            'back_bg' => null,
            'layout' => [
                'fields' => [
                    ['type' => 'photo', 'x' => 10, 'y' => 15, 'width' => 25, 'height' => 30],
                    ['type' => 'name_ar', 'x' => 40, 'y' => 15, 'fontSize' => 14],
                    ['type' => 'national_id', 'x' => 40, 'y' => 25, 'fontSize' => 11],
                    ['type' => 'qr', 'x' => 65, 'y' => 30, 'size' => 15],
                ],
            ],
        ];
    }
}
